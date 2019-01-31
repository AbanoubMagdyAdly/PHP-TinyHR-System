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
       
        $target_dir = "\wamp64\www\\tinyhr\Files\Photos\\";
        $target_file = $target_dir . basename($_FILES["Photo"]["name"]);
        $uploadOk = 1;
        $mime =getimagesize( $_FILES['Photo']['tmp_name'] );
        if ($_FILES["Photo"]["size"] > 1024*1024) {
            $this->errors["photo"] = "Sorry, your photo is too large.";
            $uploadOk = 0;
        }
        if ($mime['mime'] != "image/jpeg" && $mime['mime'] != "image/jpg") {
            $this->errors["photo"] = "Sorry, only JPG & JPEG files are allowed.";
            $uploadOk = 0;
        }

        return $uploadOk;
    }
    public function Check_cv()
    {
        $target_dir = "\wamp64\www\\tinyhr\Files\CVs\\";
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        $uploadOk = 1;
        $mime = mime_content_type($_FILES["cv"]["tmp_name"]);
        if ($_FILES["cv"]["size"] >  1024*1024) {
            $this->errors["cv"] = "Sorry, your cv is too large.";
            $uploadOk = 0;
        }
        if ($mime != "application/pdf") {
            $this->errors["cv"] = "Sorry, only pdf files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error

        return $uploadOk;
    }

    public function Upload_photo()
    {
        $target_dir = "\wamp64\www\\tinyhr\Files\Photos\\";
        $extension = explode(".", $_FILES["Photo"]["name"])[1];
        if (move_uploaded_file($_FILES["Photo"]["tmp_name"], "$target_dir{$this->username}.jpg")) {
            return 1;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    public function Upload_cv()
    {
        $target_dir = "\wamp64\www\\tinyhr\Files\CVs\\";
        $extension = explode(".", $_FILES["cv"]["name"])[1];
        if (move_uploaded_file($_FILES["cv"]["tmp_name"], "$target_dir{$this->username}.pdf")) {
            return 1;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>