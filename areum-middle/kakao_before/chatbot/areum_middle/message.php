<?php
/*
    Source Code by K040205
    Helped      by Waterticket(data parsing)
    Helped      by JunhoYeo(kakaotalk chat)
    k040205     @naver.com
    matthew218  @naver.com
    http://nogadaworks.tistory.com/
*/

    include "function/chat.php";
    include "function/log.php";

    $data = json_decode(file_get_contents('php://input'), true);
    $content = $data["content"];
    $user_key = $data["user_key"];
    

    
    $blacklist = " | ";

    if(strpos($blacklist, $user_key) !== false){
        
        rightbrace();
            message();
                echotext("블랙리스트에 올라갔습니다\\n(무분별한 도배 사용)", 0);
            endmessage(1);
        keyboard(NULL);
        leftbrace();
        exit;
    }
    
    if(/*$user_key !== "TLcmJ006R4yM" && */$user_key !== NULL)writelog("$content","$user_key");
    
    $keyboard = array("급식", "알림장", "시간표", "날씨");
    
    
    
    
    
    if(strpos($content, "급식") !== FALSE){   //급식 메뉴 소스코드
        
        include "function/meal.php";
            
        if($content == "급식"){
            rightbrace();
                message();
                    echotext("날짜를 선택해 주세요",0);
                endmessage(1);
                keyboard(array("오늘 급식", "내일 급식", "모레 급식"));
            leftbrace();  
            exit;
        }
        
        if(preg_match("/^오늘|내일|모레 급식$/", $content)){
            $text = str_replace(" 급식","", $content);
            if($text == "오늘") $day = 0;
            if($text == "내일") $day = 1;
            if($text == "모레") $day = 2;

            $arr = getmeal($day);
            rightbrace();
                message();
                    echotext("== ".$arr[0]." ==\\n".$arr[1] ,0);
                endmessage(1);
                keyboard($keyboard);
            leftbrace();
            exit;
        }
    }


    if(strpos($content, "알림장") !== FALSE){   //알림장 메뉴 소스코드

        include "function/diary.php";
        
        if($content == "알림장"){
            $var = makebutton("알림장", 0);
            rightbrace();
                message();
                    echotext("학년을 골라 주세요" , 1);
                    echolink("알림장 설정은 여기서" , "http://areum.000webhostapp.com" , 0);
                endmessage(1);
                keyboard($var);
            leftbrace();
            exit;
        }

        if(preg_match("/^[1-3]학년 알림장$/", $content)){
            $data = preg_replace("/[^0-9]*/s", "", $content);
            $var = makebutton("알림장", $data);
            rightbrace();
                message();
                    echotext("반을 선택해 주세요", 0);
                endmessage(1);
                keyboard($var);
            leftbrace();
            exit;
        }

        if(preg_match("/^[1-3] 학년 [0-9]{1,2} 반 알림장$/", $content)){
            $data = preg_replace("/[^0-9]*/s", "", $content);
            $var = diary($data);
            rightbrace();
                message();
                    echotext("알림장 담당이 정한 알림장은\\n====================\\n$var", 0);
                endmessage(1);
                keyboard($keyboard);
            leftbrace();
            exit;
        }    
    }


    if(strpos($content, "시간표") !== FALSE){  //시간표 메뉴 구현

        include "function/table.php";
        
        if($content == '시간표'){
            $var = makebutton("시간표", 0);
            rightbrace();
                message();
                    echotext("학년을 선택해 주세요" , 0);
                endmessage(1);
                keyboard($var);
            leftbrace();
            exit;
        }

        if(preg_match("/^[1-3]학년 시간표$/", $content)){
            $data = preg_replace("/[^0-9]*/s", "", $content);
            $var = makebutton("시간표", $data);
            rightbrace();
                message();
                    echotext("반을 선택해 주세요", 0);
                endmessage(1);
                keyboard($var);
            leftbrace();
            exit;
        }

        if(preg_match("/^[1-3] 학년 [0-9]{1,2} 반 시간표$/", $content)){ //학급 시간표 구현
            rightbrace();
                message();
                    echotext("날짜를 선택해 주세요", 0);
                endmessage(1);
                keyboard(array("오늘 $content", "내일 $content", "모레 $content"));
            leftbrace();
            exit;
        }    

        if(preg_match("/^오늘|내일|모레 [1-3] 학년 [0-9]{1,2} 반 시간표$/", $content)){
            $text = preg_replace("/ [1-3] 학년 [0-9]{1,2} 반 시간표$/", "", $content);
            if($text == "오늘") $day = 0;
            if($text == "내일") $day = 1;
            if($text == "모레") $day = 2;
            
            $data = preg_replace("/[^0-9]*/s", "", $content);
            $var = table($data, $day);
            rightbrace();
                message();
                    echotext("== 시간표 ==\\n$var", 0);
                endmessage(1);
                keyboard($keyboard);
            leftbrace();
            exit;
        }
    }
    
    if(strpos($content, "날씨") !== false){
        
        include "function/weather.php";
        
        if($content == "날씨"){
            rightbrace();
                message();
                    echotext("날짜를 선택해 주세요", 0);
                endmessage(1);
                keyboard(array("오늘 날씨", "내일 날씨", "모레 날씨"));
            leftbrace();
            exit;
        }
        
        if(preg_match("/^오늘|내일|모레 날씨$/", $content)){
            $text = preg_replace("/ 날씨/", "", $content);
            if($text == "오늘") $day = 0;
            if($text == "내일") $day = 1;
            if($text == "모레") $day = 2;
            
            $var = weather($day);
            rightbrace();
                message();
                    echotext("== 아름동 날씨 ==\\n$var[0]", 1);
                    echoimage($var[1] , 600 , 600 , 0);
                endmessage(1);
                keyboard($keyboard);
            leftbrace();
            exit;
        }
    }
    
    rightbrace();
        message();
            echotext("잘못된 입력입니다", 0);
        endmessage(1);
    keyboard($keyboard);
    leftbrace();    

?>