<?php
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
if ( !file_exists('blocked_ips.txt') ) {
 $deny_ips = array(
  '127.0.0.1',
  '192.168.1.1',
  '83.76.27.9',
  '192.168.1.163'
 );
} else {
 $deny_ips = file('blocked_ips.txt');
}
// read user ip adress:
$ip ="127.0.0.1";
var_dump(getRealIpAddr());
 
// search current IP in $deny_ips array
if ( (array_search($ip, $deny_ips))!== FALSE ) {
 // address is blocked:
 echo 'Your IP adress ('.$ip.') was blocked!';
}

?>