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
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] == 1) {
    if(isset($_GET["id"]) && !empty($_GET["id"]) ){
        require_once("views/admin/user.php");
    } else{
        require_once("views/admin/users.php");
    }
} elseif (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] == 0) {
    echo "logged in successfully";
    //members views should be required here
} else {
    require_once("views/public/login.php");
}
//********************************************//


