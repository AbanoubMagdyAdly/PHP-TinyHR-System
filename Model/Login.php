<?php 
class Login {

    private $user_record;
    private $db;
    private $input_hash_pass;
    public $error;

    public function set_db_record($db, $user_record, $password)
    {
        $this->input_hash_pass = hash("sha256", $password);
        $this->db          = $db;
        $this->user_record = $this->db-> get_record_by_name($user_record); // this is an array of arrays
        $this->user_record = empty($this->user_record) ? $this->user_record: $this->user_record[0];
        $this->error       = empty($this->user_record) ? "Either user name or password is wrong": "";
    }

    public function is_login_failed($name){
        if($this->user_record["username"] == $name)
        if($this->user_record["password"] != $this->input_hash_pass  && !$this->user_record["is_blocked"])
            return true;
        
        return false;
    }

    public function handle_failed_login_counter(){
        if( time() - $this->user_record["last_login_timestamp"] < __FAILED_LOGIN_TIME_SPAN_LIMIT)
            $this->user_record["login_failed_attempts"]++ ;
        
        $this->db->update_user_logincount($this->user_record);
        $this->user_record["last_login_timestamp"] = time();
        $this->error = "Either user name or password is wrong";
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

        $this->db->update_user_logincount($this->user_record);
    }

    public function reset_login_atttempts(){
        $this->user_record["login_failed_attempts"]=0;
        $this->user_record["last_login_timestamp"]= time();
    }

    public function is_fields_valid($password, $username){
        if (!empty($password) && !empty($username)) {
            if(strlen($password) < 8 || strlen($password)>16){
                $this->error = "password must be between 8 and 16 characters";
                return false;
            }
        }
        else {
            $this->error = "please enter both user name or password is wrong";
            return false;
        }
        return true;
    }

    public function check_user_exists()
    {
        if (isset($this->user_record) && !empty($this->user_record))
            return true;
        else {
            $this->error = "Either user name or password is wrong";
            return false;
        }
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

    public function matched_and_not_blocked()
    {
        if($this->input_hash_pass == $this->user_record["password"] && !$this->user_record["is_blocked"])
            return true;
        else 
            return false;
            
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

        $this->reset_login_atttempts();
        $this->db->update_user_logincount($this->user_record);
    }
    
}
?>