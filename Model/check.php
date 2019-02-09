<?php
class check{
    public function check_block($ip)
    {
        $blockdb=new BlockDB("blockips");
        $blockdb->connect();
        $blockips=$blockdb->get_blocked_ips();

        return in_array($ip,$blockips);
        
    }
}

?>