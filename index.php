<?php
require_once("autoload.php");
define("_ALLOW_ACCESS", 1);
session_start();
session_regenerate_id();
$check=new check();
if($check->check_block($_SERVER["REMOTE_ADDR"])){
   require_once("views/public/403.php");
   exit();
}
$check->cookie_check();

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
                       "block"        => function($user){$user->block();},
                       "export"       => function($user){$user->export();});

if(isset($_GET["page"])&& in_array($_GET["page"],array_keys($router_array))) {
   $router_array[$_GET["page"]]($user);
}
else
   $router_array[""]($user);