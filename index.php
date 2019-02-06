<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("autoload.php");
define("_ALLOW_ACCESS", 1);
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 200);
session_start();
session_regenerate_id();

//********************************************//
if (isset($_SESSION["user_id"]) || isset($_COOKIE["user_id"])) {
    if (isset($_GET["logout"]) && isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', '', time() - 3600, '/');
        header("refresh:0");
    } elseif (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1 || isset($_COOKIE["user_id"]) && $_COOKIE["is_admin"] == 1) {
        //admin views should be required here
            require_once("views/admin/navbar_admin.php");
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            require_once("views/admin/user.php");
        } elseif(isset($_GET["block"]) && !empty($_GET["block"])) {
            require_once("views/admin/block.php");
            
        }else{
            require_once("views/admin/users.php");
        }
    } elseif (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 0 || isset($_COOKIE["user_id"]) && $_COOKIE["is_admin"] == 0) {
        require_once("views/member/navbar_user.php");
        if (isset($_GET["edit"]) && !empty($_GET["edit"])) {
            require_once("views/member/edit_my_profile.php");
        }
        else
        {
            require_once("views/member/view_my_profile.php");
        }
        //members views should be required here
    }
} elseif (isset($_GET["signup"])) {
    require_once("views/public/signup.php");
} else {
    require_once("views/public/login.php");
}
//********************************************//