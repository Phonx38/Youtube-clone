<?php
include_once('includes/classes/videoUploadData.php');
class  VideoProcessor {

    private $con;

    private $ffmpegPath;

    private $ffProbePath;

    private $sizeLimit = 50000000;

    private $allowedTypes = array('mp4','flv','avi','mov');


    public function __construct($con) {

        $this->con = $con;
        $this->ffmpegPath =realpath("ffmpeg/bin/ffmpeg.exe");
        $this->ffProbePath = realpath("ffmpeg/bin/ffprobe.exe");
    }

    public function upload($videoUploadData) {
        //uplad videooooo
        $targetdir = "uploads/videos/";

        $videoData = $videoUploadData->videoDataArray;

        //tempPAth
        $tempFilePath =$targetdir.uniqid().basename($videoData["name"]);
        $tempFilePath = str_replace(" ","_",$tempFilePath);

        echo $tempFilePath;



        //validation

        $isValidData = $this->processData($videoData,$tempFilePath);
        
        //ifError
        if(!$isValidData)
        {
            return false;
        }
        //if moved succesfully to videos folder
        if(move_uploaded_file($videoData["tmp_name"],$tempFilePath))
        {
            $finalFilePath = $targetdir . uniqid() . ".mp4";

            if(!$this->insertVideoData($videoUploadData,$finalFilePath))
            {
                echo "insert  QUERY FAILED";
                return false;

            }
            
            //convert to mp4

            if(!$this->convertVideoToMp4($tempFilePath,$finalFilePath))
            {
                echo " Command Failed ";
                return false;
            }

            //delete original file

            if(!$this->deleteFile($tempFilePath))
            {
                echo "Couldn't Delete the File.";
                return false;
            }

            if(!$this->generateThumbnail($finalFilePath))
            {
                echo " Couldn't upload thumbnail. ";
                return false;
            }
            return true;
        }





    }
//process the uploda file
    private function processData($videoData,$finalFilePath)
    {
        $videoType = pathinfo($finalFilePath,PATHINFO_EXTENSION);

        if(!$this->isValidSize($videoData))
        {
            echo " \n FILE TOO LARGE  Can't be more than ".$this->sizeLimit . "Bytes";
            return False;
        }
        else if(!$this->isValidType($videoType))
        {
            echo " INVALID FILE TYPE " ;
            return false;

        }
        else if($this->hasError($videoData))
        {

            echo "AN ERROR OCCURED" ;
            return false;
        }

        return true;
        
    }
    private function isValidSize($videoData) {
        return $videoData["size"] <= $this->sizeLimit;
    }
    private function isValidType($videoType) {
        
        $videoType = strtolower($videoType);

        return in_array($videoType,$this->allowedTypes); 
    }
    private function hasError($videoData)
    {
        return $videoData["error"] != 0;    
    }
//insert video to database
    private function insertVideoData($videoUploadData,$finalFilePath)
    {
         

        $query =$this->con->prepare(
            "INSERT INTO video(title,uploadedBy,description,privacy,category,filepath)
                        VALUES(:title,:uploadedBy,:description,:privacy,:category,:filepath)"
        );
            $query->bindParam(":title", $videoUploadData->title);
            $query->bindParam(":uploadedBy",$videoUploadData->uploadedBy);
            $query->bindParam(":description", $videoUploadData->description);
            $query->bindParam(":privacy",$videoUploadData->privacy);
            $query->bindParam(":category",$videoUploadData->category);
            $query->bindParam(":filepath",$finalFilePath);


            return $query->execute();
    }
//convert file to mp4
    private function convertVideoToMp4($tempFilePath,$finalFilePath)
    {
        $cmd = "$this->ffmpegPath -i  $tempFilePath $finalFilePath  2>&1";

        $outputLog = array();

        exec($cmd,$outputLog,$returnCode);

        if($returnCode != 0)
        {
            foreach ($outputLog as $line ) {
                
                echo $line ."<br>";
                return false;
            }
        }

        return true;
    }
//delete file
    private function deleteFile($tempFilePath)
    {
        if(!unlink($tempFilePath))
        {
            echo " Couldn't delete the file. ";
            return false;
        }

        return true;
    }


    private function generateThumbnail($finalFilePath)
    {
        $thumbnailSize = "210x118";
        $nmThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";

        $duration = $this->getVideoDuration($finalFilePath);
        
        $videoId = $this->con->lastInsertId();

        $this->updateDuration($duration,$videoId);

        for($num=1;$num<=3;$num++)
        {
            $imageName= uniqid() . ".jpg";
            $interval = ($duration * 0.8) / $nmThumbnails * $num;
            $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";


            $cmd = "$this->ffmpegPath -i  $finalFilePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";

            $outputLog = array();

            exec($cmd,$outputLog,$returnCode);

            if($returnCode != 0)
            {
                foreach($outputLog as $line ) {
                    
                    echo $line ."<br>";
                    
                }

            }

            $query = $this->con->prepare("INSERT INTO thumbnails(videoId,filePath,selected)
                                           VALUES(:videoId,:filePath,:selected)             

            ");

            $query->bindParam(":videoId",$videoId);
            $query->bindParam(":filePath",$fullThumbnailPath);
            $query->bindParam(":selected",$selected);

            $selected = $num == 1 ? 1 : 0;

            $success= $query->execute();

            if(!$success)
            {
                echo "Insert failed";
                return false;
            }


        }
        
        return true;
    }

    private function getVideoDuration($finalFilePath)
    {
        return (int) shell_exec("$this->ffProbePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $finalFilePath");
    }
//insert duraation to db
    private function updateDuration($duration,$videoId)
    {
        


        $hours= floor($duration/3600);
        $minutes = floor(($duration -  ($hours *  3600)) / 60);
        $secs = floor($duration % 60);

        if($hours<1){
            $hours = " ";

        }
        else
        {
            $hours = $hours . ":";
        }

        if($minutes<10){
            $minutes = "0". $minutes . ":";

        }
        else
        {
            $minutes = $minutes . ":";
        }

        if($secs<1){
            $secs = "0".$secs;

        }
        else
        {
            $secs = $secs;
        }

        $duration = $hours.$minutes.$secs;

        $query = $this->con->prepare("UPDATE video SET duration=:duration
        WHERE id=:id
        ");

        $query->bindParam(":duration",$duration);
        $query->bindParam(":id",$videoId);

        return $query->execute();
    }
}



?>