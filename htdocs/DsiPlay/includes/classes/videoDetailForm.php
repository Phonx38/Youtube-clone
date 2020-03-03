<?php

class videoDetailFormProvider{

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }


    public function createUploadForm(){
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput();
        $descriptionInput = $this->createDescriptionInput();
        $privacyInput = $this->createPrivacyInput();
        $categoryInput= $this->createCategoryInput();
        $uploadButton= $this->createUploadButton();
        return "
            <form action='processing.php' method='POST' enctype='multipart/form-data'>
                $fileInput
                $titleInput
                $descriptionInput
                $privacyInput
                $categoryInput
                $uploadButton
            </form>
        
        ";
    
    }
    private function createFileInput() {
        return '
        <div class= "form-group">
            <input type="file" class="form-control-file" name="fileInput" id="exampleFormControlFile1" required>
        </div>
        ' ;
    }
    private function createTitleInput() {
        return '
        <div class="form-group">
            <input type="text" name="titleInput" class="form-control" placeholder="Title" required>
        </div>
        ';
    }
    private function createDescriptionInput() {
        return '
        <div class="form-group">
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descriptionInput" placeholder="Description"></textarea>
        </div>
        ';
    }
    private function createPrivacyInput() {
        return '
        <div class="form-group">
            
            <select class="form-control"name="privacyInput" id="exampleFormControlSelect1">
            <option value="1">Public</option>
            <option value= "0">Private</option>
            
            </select>
      </div>
        
        ';
    }
    private function createCategoryInput() {
        $query= $this->con->prepare("SELECT * from categories");
        $query->execute();

        $html = '
        <div class="form-group">
            
            <select class="form-control" name="categoryInput" id="exampleFormControlSelect1">
        ';
    
        while($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $name= $row["name"];
            $id=$row["id"];
            $html.= " <option value='$id'>$name</option>";
        }

        $html.='
        </select>
        </div>
        ';

        return $html;
    }

    private function createUploadButton() {
        $html ="<button name='uploadButton' class = 'btn btn-primary'>Upload</button>";

        return $html;
    }
}
?>