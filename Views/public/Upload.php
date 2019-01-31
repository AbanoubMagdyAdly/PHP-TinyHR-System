<?php
class Upload
{
    private $username;
    public $errors = array();
    public function __construct($username)
    {
        $this->username = $username;
    }
    public function Check_photo()
    {
        $target_file = $target_dir . basename($_FILES["Photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["Photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $this->errors[] = "File is not an image.";
            $uploadOk = 0;
        }
        if ($_FILES["Photo"]["size"] > 1000000) {
            $this->errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $this->errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        return $uploadOk;
    }
    public function Check_cv()
    {
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        $uploadOk = 1;
        $cvFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($_FILES["cv"]["size"] > 1000000) {
            $this->errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($cvFileType != "pdf") {
            $this->errors[] = "Sorry, only pdf files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error

        return $uploadOk;
    }

    public function Upload_photo()
    {
        $extension = explode(".", $_FILES["Photo"]["name"])[1];
        if (move_uploaded_file($_FILES["Photo"]["tmp_name"], "$target_dir{$this->username}.jpg")) {
            echo "The file " . basename($this->username) . " has been uploaded.";
            return 1;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    public function Upload_cv()
    {
        $extension = explode(".", $_FILES["cv"]["name"])[1];
        if (move_uploaded_file($_FILES["cv"]["tmp_name"], "$target_dir{$this->username}.pdf")) {
            echo "The file " . basename($this->username) . " has been uploaded.";
            return 1;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>