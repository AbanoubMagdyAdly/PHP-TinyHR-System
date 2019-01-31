<?php
Class UsersDB {
    private $_db_handler;
    private $_table;

    public function __construct($table){
        $this->_table = $table;
    }

    public function connect(){
        @$handler = mysqli_connect(__HOST__, __USER__, __PASS__, __DB__  );
        if($handler){
            $this->_db_handler = $handler;
            return true;
        } else {
            return false;
        }
    }

    public function disconnect()
    { 
        if($this->_db_handler){
            mysqli_close($this->_db_handler);
        }
    }

    public function get_data($fields = array(),  $start = 0){
        $table = $this->_table;

        if(empty($fields)){
            $sql = "select * from $table";
        } else {
            $sql = "select";
            foreach($fields as $f){
                $sql .= " $f , ";
            }
            $sql .="from $table ";
            $sql = str_replace(", from", "from", $sql); 
        }

        $sql .= " limit $start,".__RECORDS_PER_PAGE__;
        
        return $this->get_results($sql);
    }

    public function get_record_by_id($value)
    {
        $sql = "select * from users where id = $value;";
        
        return $this->get_results($sql);
    }

    public function get_record_by_name_pass($name, $password)
    {
        $sql = "select * from users where username = '$name' AND password = '$password';";
        
        return $this->get_results($sql);
    }

    public function get_results($sql){
        if(__DEBUG_MODE__ == 1){
            echo "<br>".$sql."</br>";
        }

        $result_handler = mysqli_query($this->_db_handler, $sql);
        $_arr_results = array();
        
        if($result_handler){
            while($row = mysqli_fetch_assoc($result_handler)){
                $_arr_results[] = array_change_key_case($row);
            }
            return $_arr_results;
        } else {
            $this->disconnect();
            return false;
        }
    }

    public function search($column, $column_value){
        $table = $this->_table;
        $sql = "select * from $table where $column like '%".$column_value."%'";
        return $this->get_results($sql);
    }

    public function is_exist($username)
    {
        $table =$this->_table;
        $sql = "select * from $table where username like '%".$username."%'";
        return $this->get_results($sql);
    }

    public function insert_user_date($username,$password,$email,$job)
    {
        $table =$this->_table;
        $sql="insert into $table (username, password,email, job, hasphoto, hascv, isadmin) VALUES ('$username', '$password','$email','$job', '1', '1', '0');";
        mysqli_query($this->_db_handler, $sql);
        echo mysqli_error($this->_db_handler);
        $this->disconnect();
    }

/*     public function get_results_parametrized($sql, $value){
        if(__DEBUG_MODE__ == 1){
            echo $sql."<br></br>";
        }

        if($stmt = mysqli_prepare($this->_db_handler, $sql)){
            $stmt->bind_param("i", $value);
            $result_handler = $stmt->execute();
            
            $_arr_results = array();
            if($result_handler){                
                while($row = mysqli_fetch_assoc($result_handler)){
                    $_arr_results[] = array_change_key_case($row);
                }
                return $_arr_results;
            } else {
                $this->disconnect();
                return false;
            }
        }
    } 
*/

}

?>


