<?php

class Pagination{
    private $current_page;
    private $upper_limit;
    private $lower_limit;

    public function __construct($current_page, $members_count)
    {
        $this->current_page  = $current_page;
        $this->lower_limit   = 0;
        $this->upper_limit   = ceil($members_count / __RECORDS_PER_PAGE__) - 1;
    }

    public function nextPage(){
        $this->current_page+=1;
        
        $this->current_page = $this->current_page > $this->upper_limit ? $this->upper_limit : $this->current_page;

        return $this->current_page;
    }

    public function prevPage(){
        
        $this->current_page-=1;
    
        $this->current_page = $this->current_page < $this->lower_limit ? $this->lower_limit :  $this->current_page;
    
        return $this->current_page;
    }

    public function handle_url_upper_limit(){
        if(isset($_GET["currentpage"]) && $_GET["currentpage"] > $this->upper_limit){
            $_GET["currentpage"] = $upper_limit;
            $location = "$_SERVER[PHP_SELF]" . "?currentpage=$this->upper_limit";
            header("location: $location");
        }
    }

    public function handle_url_lower_limit(){
        if(isset($_GET["currentpage"]) && $_GET["currentpage"] < $this->lower_limit ){
            $_GET["currentpage"] = $lower_limit;
            $location = "$_SERVER[PHP_SELF]" . "?currentpage=$this->lower_limit";
            header("location: $location");
        }
    }

}

?>