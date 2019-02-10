<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
require_once("config.php");
function my_autoloader($class) {    
    $path = __DIR__.'/Model/' . $class . '.php';
    if (file_exists($path)) {
        
        require_once($path);
    } else {
       throw new Exception("Class ".$class." dosn't found");
                
    }
}

spl_autoload_register('my_autoloader');


