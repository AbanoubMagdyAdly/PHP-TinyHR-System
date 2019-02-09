<?php 
class Login {

    private $user_record;

    public function put_db_recored($user_record)
    {
        $this->user_record = $user_record;
        
    }

    public function get_user(){
        return $this->user_record;
    }

    public function is_login_failed($name, $password){
        if($this->user_record["username"] == $name)
        if($this->user_record["password"] != $password && !$this->user_record["is_blocked"])
            return true;
        
        return false;
    }

    public function handle_failed_login_counter(){
        if( time() - $this->user_record["last_login_timestamp"] < __FAILED_LOGIN_TIME_SPAN_LIMIT)
            $this->user_record["login_failed_attempts"]++ ;
        
        $this->user_record["last_login_timestamp"] = time();
    }

    public function handle_failed_login(){
        if(!$this->user_record["is_blocked"] && $this->user_record["login_failed_attempts"] >= __FAILED_LOGIN_ATTEMPTS_LIMIT){
            if( time() - $this->user_record["last_login_timestamp"] <__FAILED_LOGIN_TIME_SPAN_LIMIT){
                $this->user_record["is_blocked"] = 1;
                $this->user_record["last_login_timestamp"] = time();
            }
        }
        
        if($this->user_record["is_blocked"] && (time() - $this->user_record["last_login_timestamp"] > __BLOCK_TIME)){
            $this->user_record["is_blocked"] = false;
            $this->user_record["login_failed_attempts"]=0;
        }
    }

    public function reset_login_atttempts(){
        $this->user_record["login_failed_attempts"]=0;
    }

    public function check_fields_criteria(){
        $error = "";
        if (!empty($_POST["password"]) && !empty($_POST["username"])) {
            if(strlen($_POST["password"]) < 8 || strlen($_POST["password"])>16){
                $error = "password must be between 8 and 16 characters";
            }
        }
        else {
            $error = "please enter both user name or password is wrong";
        }
        return $error;
    }

    public function check_is_found($user_record)
    {
        if (isset($user_record) && !empty($user_record))
            $error = "";
        else
            $error = "Either user name or password is wrong";
        return $error;
    }

    public function show_block_timer()
    {
        if($this->user_record["is_blocked"]){
            echo "this account has exceeded the failed log in limit, please try again in:";
            echo date("i s",  __BLOCK_TIME-(time() - $this->user_record["last_login_timestamp"]));
            echo "s";
            die();
        }
    }

    public function authenticate($rememberme)
    {
        $_SESSION["user_id"] = $this->user_record["id"];
        $_SESSION["is_admin"] = $this->user_record["isadmin"];

        if($rememberme){
            $token  = $this->user_record["id"] .",".  $this->user_record["isadmin"];
            $token = Crypto::encrypt($token, __SALT);
            setcookie("token",$token,time()+60*60*24*31,'/');
        }

        $this->user_record["login_failed_attempts"]=0;
        $this->reset_login_atttempts();
    }
    
}
?>