<?php 
class BlockDB{

    private $_db_handler;
    private $_table;

    public function __construct($table)
    {
        $this->_table = $table;
    }

    public function connect()
    {
        @$handler = mysqli_connect(__HOST__, __USER__, __PASS__, __DB__);
        if ($handler) {
            $this->_db_handler = $handler;
            return true;
        } else {
            return false;
        }
    }
    public function disconnect()
    {
        if ($this->_db_handler) {
            mysqli_close($this->_db_handler);
        }
    }

    public function get_blocked_ips()
    {
        $table = $this->_table;

            $sql = "select ip from $table";

        return $this->get_results($sql);
    }

    public function get_results($sql)
    {
        if (__DEBUG_MODE__ == 1) {
            echo "<br>" . $sql . "</br>";
        }

        $result_handler = mysqli_query($this->_db_handler, $sql);
        $_arr_results = array();

        if ($result_handler) {
            while ($row = mysqli_fetch_assoc($result_handler)) {
                $_arr_results[] = array_change_key_case($row);
            }
            foreach ($_arr_results as $res)
            {
                $ips[]=$res["ip"];
            }
            return $ips;
        } else {
            return false;
        }
    }
    public function insert_ip($ip)
    {
        $table = $this->_table;
        $sql = "insert into $table (ip) VALUES ('$ip');";
        mysqli_query($this->_db_handler, $sql);
        echo mysqli_error($this->_db_handler);
    }
    public function delete_ip($ip) {
        $table = $this->_table;
        $key = "ip";
        $sql = "delete  from `" . $table . "` where `" . $key . "` = '$ip'";
        if (mysqli_query($this->_db_handler, $sql)) {
            $this->disconnect();
            return true;
        } else {
            $this->disconnect();
            return false;
        }
    }

}

?>