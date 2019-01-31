<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("autoload.php");
define("_ALLOW_ACCESS", 1);
session_start();
session_regenerate_id();

//********************************************//
//Routing
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] == 1||isset($_COOKIE["user_id"])&&$_COOKIE["is_admin"]==1) {
    //admin views should be required here
    if(isset($_GET["id"]) && !empty($_GET["id"]) ){
        require_once("views/admin/user.php");
    } else{
        require_once("views/admin/users.php");
    }
    // setcookie("user_id",'$_SESSION["user_id"]',time()+31556926 ,'/');
    // setcookie("is_admin",'$_SESSION["is_admin"]',time()+31556926 ,'/');
} elseif (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] == 0||isset($_COOKIE["user_id"])&&$_COOKIE["is_admin"]==0) {
    echo "logged in successfully";
    //members views should be required here
    // setcookie("user_id",'$_SESSION["user_id"]',time()+31556926 ,'/');
    // setcookie("is_admin",'$_SESSION["is_admin"]',time()+31556926 ,'/');
} elseif (isset($_GET["signup"])) {
    require_once("views/public/signup.php");
} else {
    require_once("views/public/login.php");
}
//********************************************//
