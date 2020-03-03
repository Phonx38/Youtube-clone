<?php


class VideoPlayer {

    private $video;

    public function __construct($video)
    {
        $this->video= $video;
    }
    public function create($autoplay)
    {
        if($autoplay) {
            $autoplay = "autoplay";

        }
        else{
            $autoplay ="";

        }
        $filepath = $this->video->getFilePath();
        return "<video class='videoPlayer' controls $autoplay>
                    <source src='$filepath' type='video/mp4'>
                    Your browser does not support mp4.
        
                </video>";
    }
}



?>