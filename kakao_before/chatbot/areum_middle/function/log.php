<?php

function writelog($text , $user){
    date_default_timezone_set("Asia/Seoul");
    $date = date( 'Y-m-d H:i:s', time() );
    $fp = fopen("./data/log.txt" , "a");
    fwrite($fp,"$user - $date \n", 1024);
    fclose($fp);
    return;
}

?>