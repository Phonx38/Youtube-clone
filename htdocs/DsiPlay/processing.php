<?php include_once('includes/header.php');
include_once('includes/classes/videoUploadData.php');
include_once('includes/classes/videoProcessor.php');

//setting and checking upload button

if(!isset($_POST['uploadButton']))
{
    echo 'No Form Data is Sent!!';
}
//file upload data

$videoUploadData =new videoUploadData($_FILES['fileInput'],$_POST['titleInput'],$_POST['descriptionInput'],$_POST['privacyInput'],$_POST['categoryInput'],$userLoggedInObj->getUn());

$videoProcessor = new videoProcessor($con);

$wasSuccessful = $videoProcessor->upload($videoUploadData);

if($wasSuccessful)
{
    echo "Video Uploaded";
}

?>