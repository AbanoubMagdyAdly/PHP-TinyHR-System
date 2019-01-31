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
        $target_dir = "Files\Photos\\";
        $target_file = $target_dir . basename($_FILES["Photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($_FILES["Photo"]["size"] > 1000000) {
            $this->errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
            $this->errors[] = "Sorry, only JPG & JPEG files are allowed.";
            $uploadOk = 0;
        }

        return $uploadOk;
    }
    public function Check_cv()
    {
        $target_dir = "Files\CVs\\";
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
        $target_dir = "Files\Photos\\";
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