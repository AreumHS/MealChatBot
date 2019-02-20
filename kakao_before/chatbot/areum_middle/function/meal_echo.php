<?php

//////////Functions///////////
    
    function getLines($file){  $f = fopen($file, 'rb');  $lines = 0;  while (!feof($f)) {  $lines += substr_count(fread($f, 8192), "\n");  }  fclose($f);  return $lines;  }//줄 수를 세주는 함수

date_default_timezone_set('Asia/Seoul');
$date = (date('w'));
if($date == 6 && $bool == 0) { $bool = 0; }
if($date == 0) {echo '일요일/급식 없음'; return;}
if($date == 6) {echo '토요일/급식 없음'; return;}
if($date == 0 && $bool == 1) {
    
    
//////////////Waterticket's food parse//////////////
    $schulCode = "I100000108";  $officecode = "sje.go.kr";  $schulScCode = "3";   $schMmealCode = "2";
    $schYmd = date("Y.m.d", mktime(0,0,0,date("m")  , date("d"), date("Y"))); //오늘 날짜
    $food_url = 'http://stu.'.$officecode.'/sts_sci_md01_001.do?schulCode='.$schulCode.'&schulCrseScCode='.$schulScCode.'&schMmealScCode='.$schMmealCode.'&schYmd='.$schYmd;
    $text = file_get_contents($food_url); 
    $temp = @explode('<table', $text); 
    $tmp = '<table border="1" '.$temp[1];
    $temp = @explode('</table>', $tmp); 
    //echo "파싱한 홈페이지 : $food_url</br>";
    
//////////////Data modification /////////////////

    $a[0] = strstr(  $temp[0]  ,'중식');
    $a[1] = strstr( $a[0] ,'식재료'  );
    $a[2] = explode( $a[1] , $a[0] );
    $a[3] = str_replace('중식','', $a[2][0]);
    
//////////////File output////////////////
    $fp = fopen('../data/week_meal.txt','w');
    fwrite($fp,$a[3],strlen($a[3]));
    fclose($fp);
    
}

//////////File input////////////
    $lines = getLines('../data/week_meal.txt');
    $fp = fopen('../data/week_meal.txt', 'r');
    for($i = 0; $i < $lines; $i++){  $array[$i] = fgets($fp,1024);  }//줄 읽어오기
    for($i = 0; $i < $lines; $i++){  $array[$i] = trim($array[$i]); }//공백 제거하기
    fclose($fp);

//////////Data Modification//////////////
    $a[0] = preg_replace('/[0-9]/' , "" , $array[$date + 1]);
    $b = strip_tags($a[0], '<br>');
    $c = preg_replace("/[.&]{1,}/", "", $b);
    $meal = str_replace("<br />", "\r\n", $c);
    
    echo $meal;
?>