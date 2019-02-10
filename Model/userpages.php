<?php

class userpages{

    public function main(){
        if (isset($_SESSION["user_id"])){
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
                $this->view_users();
            }
            else{
                $this->user_profile();
            }
        }
        else{
            $this->login();
        }
    }

    public function view_users(){
        if (isset($_SESSION["user_id"])){
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
                require_once("views/admin/navbar_admin.php");
                    require_once("views/admin/users.php");
                }
            else{
                require_once("views/member/navbar_user.php");
                require_once("views/public/403.php");
            }
            }
        else{
            $this->login();
        }
        }
    public function profile(){
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
            require_once("views/admin/navbar_admin.php");
            require_once("views/admin/user.php");
        }
        else{
            require_once("views/member/navbar_user.php");
            require_once("views/public/403.php");
        }
    }
    else{
        $this->login();
    }
}
    public function block(){
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
            require_once("views/admin/navbar_admin.php");
            require_once("views/admin/block.php");
        }
        else{
            require_once("views/member/navbar_user.php");
            require_once("views/public/403.php");
        }
    }
    else{
        $this->login();
    }
}
public function export(){
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1){
            require_once("views/admin/export_users.php");
            require_once("views/admin/navbar_admin.php");
            require_once("views/admin/users.php");
        }
        else{
            require_once("views/member/navbar_user.php");
            require_once("views/public/403.php");
        }
    }
    else{
        $this->login();
    }
}
    public function user_profile(){
        if (isset($_SESSION["user_id"])){
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 0){
                require_once("views/member/navbar_user.php");
                require_once("views/member/view_my_profile.php");

            }
            else{
                require_once("views/public/403.php");
            }
        }
        else{
            $this->login();
        }
    }
    public function edit_profile(){
        if (isset($_SESSION["user_id"])){
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 0){
                require_once("views/member/navbar_user.php");
                require_once("views/member/edit_my_profile.php");
            }
            else{
                require_once("views/admin/navbar_admin.php");
                require_once("views/public/403.php");
            }
        }
        else{
            $this->login();
        }
    }

    public function login()
    {
        require_once("views/public/login.php");
    }
    public function signup()
    {
        require_once("views/public/signup.php");
    }
    public function logout(){
        setcookie('PHPSESSID', '', time() - 3600, '/');
        setcookie("token","",time() - 3600,'/');
        session_destroy();
        header("refresh:0; URL=?");
    }
}