<?php
function rightbrace(){  echo '{';  return;}//시작시 사용
function leftbrace() {  echo '}';  return;}//끝날때 사용
function message(){  echo '"message": {';  return;}//메시지 시작시 사용

function endmessage($bool){
    if($bool == 1){    echo '},';    return;}
    if($bool == 0){    echo '}' ;    return;}
}

function echotext($text , $bool){//글씨 출력
    if($bool == 1){    echo '"text":"'."$text".'",';    return;}
    if($bool == 0){    echo '"text":"'."$text".'"';     return;}
}

function echoimage($url , $width , $height , $bool){//사진 출력
    if($bool == 1){    echo '"photo": {"url": "'."$url".'","width": '."$width".',"height": '."$height".'},';  return;}
    if($bool == 0){    echo '"photo": {"url": "'."$url".'","width": '."$width".',"height": '."$height".'}';   return;}    
}

function echolink($label , $url , $bool){//url 출력
    if($bool == 1){    echo '"message_button": {"label": "'."$label".'","url": "'."$url".'"},';   return;}
    if($bool == 0){    echo '"message_button": {"label": "'."$label".'","url": "'."$url".'"}';    return;}    
}

function keyboard($button_name){ // $button_name는 버튼 이름으로 구성된 배열
    $buttons = '"buttons" : [';
    for ($i = 0; $i < count($button_name); $i++) {
      $buttons = $buttons . '"' . $button_name[$i] . '"';
      if ($i !== count($button_name)-1){
        $buttons = $buttons . ', ';
      }
    }
    $buttons = $buttons . '] ';
    $keyboard = '"keyboard" : { "type" : "buttons", '."$buttons".'} ';
    echo $keyboard;
    return;
}

function makebutton($what, $grade){
    if($grade  == 0){
        $return = array(
            "1학년 $what",
            "2학년 $what",
            "3학년 $what",
        );
    }
    if($grade == 1 || $grade == 2 || $grade == 3){
        $return = array(
            "$grade 학년 1 반 $what",
            "$grade 학년 2 반 $what",
            "$grade 학년 3 반 $what",
            "$grade 학년 4 반 $what",
            "$grade 학년 5 반 $what",
            "$grade 학년 6 반 $what",
            "$grade 학년 7 반 $what",
            "$grade 학년 8 반 $what",
            "$grade 학년 9 반 $what",
            "$grade 학년 10 반 $what",
            "$grade 학년 11 반 $what",
            "$grade 학년 12 반 $what",
            "$grade 학년 13 반 $what",
        );
    }
    return $return;
}
?>