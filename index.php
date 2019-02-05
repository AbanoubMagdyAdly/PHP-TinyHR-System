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
if (isset($_SESSION["user_id"])) {
    if (isset($_GET["logout"]) && isset($_COOKIE['PHPSESSID'])) {
        setcookie('PHPSESSID', '', time() - 3600, '/');
        header("refresh:0");
    } elseif ($_SESSION["is_admin"] == 1 || isset($_COOKIE["user_id"]) && $_COOKIE["is_admin"] == 1) {
        //admin views should be required here
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            require_once("views/admin/user.php");
        } else {
            require_once("views/admin/users.php");
        }
    } elseif ($_SESSION["is_admin"] == 0 || isset($_COOKIE["user_id"]) && $_COOKIE["is_admin"] == 0) {
        require_once("views/member/view_my_profile.php");
    }
} elseif (isset($_GET["signup"])) {
    require_once("views/public/signup.php");
} else {
    require_once("views/public/login.php");
}
//********************************************//