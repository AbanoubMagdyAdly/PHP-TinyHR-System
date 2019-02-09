<?php

require_once("autoload.php");
define("_ALLOW_ACCESS", 1);
session_start();
session_regenerate_id();

if(isset($_COOKIE["token"])){
   $data = Crypto::decrypt($_COOKIE["token"],__SALT);
   $data = explode(",",$data);
   if(is_numeric($data[0])){
      $_SESSION["user_id"]  = $data[0];
      $_SESSION["is_admin"] = $data[1];
   } else {
      setcookie("token","",time()-3600);
   };
}

//********************************************//
$user =new userpages();
$router_array = array( "login"        => function($user){$user->login();},
                       "logout"       => function($user){$user->logout();} ,
                       "edit"         => function($user){$user->edit_profile();},
                       "profile"      => function($user){$user->profile() ;},
                       "users"        => function($user){$user->view_users();},
                       "signup"       => function($user){$user->signup() ;},
                       "userprofile"  => function($user){$user->user_profile();},
                       ""             => function($user){$user->main();} ,
                       "block"        => function($user){$user->block();});

if(isset($_GET["page"])&& in_array($_GET["page"],array_keys($router_array))) {
   $router_array[$_GET["page"]]($user);
}
else
   $router_array[""]($user);