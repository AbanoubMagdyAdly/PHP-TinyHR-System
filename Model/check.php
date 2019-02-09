<?php
class check{
    public function check_block($ip)
    {
        $blockdb=new BlockDB("blockips");
        $blockdb->connect();
        $blockips=$blockdb->get_blocked_ips();

        return in_array($ip,$blockips);
        
    }
     public function cookie_check()
    {
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
    }
}

?>