<?php

function block($ip)
{
  $blockdb=new BlockDB("blockips");
  $blockdb->connect();
  $blockdb->insert_ip($ip);
  
}
function unblock($ip)
{
  $blockdb=new BlockDB("blockips");
  $blockdb->connect();
  $blockdb->delete_ip($ip);
}
if(isset($_POST["submit"])){
if($_POST["submit"]=="block")
{
  $ip= $_POST["block1"].".".$_POST["block2"].".".$_POST["block3"].".".$_POST["block4"];
  block($ip);
}
else{
  $ip= $_POST["unblock1"].".".$_POST["unblock2"].".".$_POST["unblock3"].".".$_POST["unblock4"];
  unblock($ip);
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>block</title>
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link href="views/admin/css/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="views/admin/css/style.css">
    <link rel="stylesheet" href="views/admin/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="vendors/linericon/style.css"> -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="vendors/lightbox/simpleLightbox.css">
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="vendors/animate-css/animate.css">
    <link rel="stylesheet" href="vendors/popup/magnific-popup.css">
    <link rel="stylesheet" href="vendors/flaticon/flaticon.css"> -->
    <!-- main css -->
    <link rel="stylesheet" href="views/admin/css/style1.css">
    <link rel="stylesheet" href="views/admin/css/responsive.css">
    <!--===============================================================================================-->
</head>

<body>
<br>
<br><br>
<br>
<center>
<h1> Enter ip to block </h1>
<form method="post" action="#">
<input type="text" name="block1"size="3"maxlength = "3">
<input type="text" name="block2"size="3"maxlength = "3">
<input type="text" name="block3"size="3"maxlength = "3">
<input type="text" name="block4"size="3"maxlength = "3">
<br>
<br>
<input type ="submit" name="submit" value="block">
</form>
<br>
<br>
<h1> Enter ip to unblock </h1>
<form method="post" action="#">
<input type="text" name="unblock1"size="3"maxlength = "3">
<input type="text" name="unblock2"size="3"maxlength = "3">
<input type="text" name="unblock3"size="3"maxlength = "3">
<input type="text" name="unblock4"size="3"maxlength = "3">
<br>
<br>
<input type ="submit" name="submit" value="unblock">
</form>
</center>
</body>

</html>