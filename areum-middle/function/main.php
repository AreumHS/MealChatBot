<?php
    function kakao_reply($message , $user_key){     

        include "chat.php";
        include "database.php";
        
        $basic = array("급식", "시간표", "알림장", "날씨", "설정");
        $blacklist = "test";
        $day = NULL;
        $class = down_class($user_key);
        $class_setting = array("학년/반 설정");
        
        $last = down_message($user_key);     
        up_message($message , $user_key);
        
        /*if(strpos($blacklist , $user_key) || $last == $message){ // 블랙리스트 처리
            kakao("도배 감지됨",0,0,array(NULL));
            exit;
        }*/
        if($class == NULL && $message != "학년/반 설정" && $last != "학년/반 설정"){
            kakao("학년/반을 먼저 설정해주세요",0,0,$class_setting);
            exit;
        }
        
        if(strpos($message , "설정") !== false || $last == "알림장 설정" || $last == "학년/반 설정"){ // 설정
            if($message == "설정"){
                kakao("메뉴를 선택해 주세요",0,0,array("알림장 설정", "학년/반 설정"));
                exit;
            }
            if($message == "알림장 설정"){
                kakao("내용을 입력해 주세요",0,0,0);
                exit;
            }
            if($message == "학년/반 설정"){
                kakao("숫자만 입력해 주세요\\n예시_ 2학년 12반 => 212",0,0,0);
                exit;
            }
            if($last == "알림장 설정"){
                up_diary($message , $user_key);
                kakao("업데이트 성공",0,0,$basic);
                exit;
            }
            if($last == "학년/반 설정"){
                up_class($message , $user_key);
                kakao("업데이트 성공",0,0,$basic);
                exit;
            }
        }
        if(strpos($message , "급식") !== false){ // 급식
            if($message == "급식"){
                kakao("날짜를 선택해 주세요",0,0,array("오늘 급식", "내일 급식", "모레 급식"));
                exit;
            }
            if(preg_match("/^오늘|내일|모레 급식$/", $message)){
                $text = str_replace(" 급식","", $message);
                if($text == "오늘") $day = 0;
                if($text == "내일") $day = 1;
                if($text == "모레") $day = 2;
    
                $data = down_meal($day);
                kakao("$data[0]\\n============\\n$data[1]",0,0,$basic);
                exit;
            }
        }
        if(strpos($message , "알림장") !== false){ // 알림장
            if($message == "알림장"){
                $data = down_diary($user_key);
                kakao("$data[0]\\n============\\n$data[1]",0,0,$basic);
                exit;
            }
        }
        if(strpos($message , "시간표") !== false){ // 시간표
            if($message == "시간표"){
                kakao("날짜를 선택해 주세요",0,0,array("오늘 시간표", "내일 시간표", "모레 시간표"));
                exit;
            }
            if(preg_match("/^오늘|내일|모레 시간표$/", $message)){
                $text = str_replace(" 시간표","", $message);
                if($text == "오늘") $day = 0;
                if($text == "내일") $day = 1;
                if($text == "모레") $day = 2;
    
                $data = down_table($user_key , $day);
                kakao("$data[0]\\n============\\n$data[1]",0,0,$basic);
                exit;
            }
        }
        if(strpos($message , "날씨") !== false){ // 날씨
            if($message == "날씨"){
                kakao("날짜를 선택해 주세요",0,0,array("오늘 날씨", "내일 날씨", "모레 날씨"));
                exit;
            }
            if(preg_match("/^오늘|내일|모레 날씨$/", $message)){
                $text = str_replace(" 날씨","", $message);
                if($text == "오늘") $day = 0;
                if($text == "내일") $day = 1;
                if($text == "모레") $day = 2;
    
                $data = down_weather($day);
                kakao("$data[0]\\n============\\n$data[1]",0,0,$basic);
                exit;
            }
        }
        kakao("잘못된 입력입니다",0,0,$basic);
        exit;
    }
    
    function facebook_reply($user_key , $message){
        
        include "chat.php";
        include "database.php";
        
        $basic = array("급식", "시간표", "알림장", "날씨", "설정");
        $blacklist = "test";
        $day = NULL;
        $class = down_class($user_key);
        $class_setting = array("학년/반 설정");
        
        /*if(strpos($blacklist , $user_key) || $last == $message){ // 블랙리스트 처리
            return facebook( $user_key,"도배 감지됨",array(NULL));
            exit;
        }*/
        if($class == NULL && strpos($message, "설정") == false){
            return facebook($user_key,"학년/반을 먼저 설정해주세요",$class_setting);
            exit;
        }
        
        if(strpos($message , "설정") !== false || strpos($message , "학년반 설정") !== false || strpos($message , "알림장 설정") !== false){ // 설정
            if($message == "설정"){
                return facebook( $user_key,"메뉴를 선택해 주세요",array("알림장 설정", "학년/반 설정"));
                exit;
            }
            if($message == "알림장 설정"){
                return facebook( $user_key,"앞에 알림장 설정을 붙여주세요\\n예시_ 알림장 테스트 => 알림장 설정 알림장 테스트",0);
                exit;
            }
            if($message == "학년/반 설정"){
                return facebook( $user_key,"앞에 학년반 설정을 붙여주시고\\n숫자만 입력해 주세요\\n예시_ 2학년 12반 => 학년반 설정 212",0);
                exit;
            }
            if(strpos($message , "알림장 설정") !== false && $message != "알림장 설정"){
                $message = str_replace("알림장 설정 ", "", $message);
                up_diary($message , $user_key);
                return facebook( $user_key,"업데이트 성공",$basic);
                exit;
            }
            if(strpos($message , "학년반 설정") !== false){
                up_class($message , $user_key);
                return facebook( $user_key,"업데이트 성공",$basic);
                exit;
            }
        }
        if(strpos($message , "급식") !== false){ // 급식
            if($message == "급식"){
                return facebook( $user_key,"날짜를 선택해 주세요",array("오늘 급식", "내일 급식", "모레 급식"));
                exit;
            }
            if(preg_match("/^오늘|내일|모레 급식$/", $message)){
                $text = str_replace(" 급식","", $message);
                if($text == "오늘") $day = 0;
                if($text == "내일") $day = 1;
                if($text == "모레") $day = 2;

                $data = down_meal($day);
                return facebook( $user_key,"$data[0]\\n============\\n$data[1]",$basic);
                exit;
            }
        }
        if(strpos($message , "알림장") !== false){ // 알림장
            if($message == "알림장"){
                $data = down_diary($user_key);
                return facebook( $user_key,"$data[0]\\n============\\n$data[1]",$basic);
                exit;
            }
        }
        if(strpos($message , "시간표") !== false){ // 시간표
            if($message == "시간표"){
                return facebook( $user_key,"날짜를 선택해 주세요",array("오늘 시간표", "내일 시간표", "모레 시간표"));
                exit;
            }
            if(preg_match("/^오늘|내일|모레 시간표$/", $message)){
                $text = str_replace(" 시간표","", $message);
                if($text == "오늘") $day = 0;
                if($text == "내일") $day = 1;
                if($text == "모레") $day = 2;
    
                $data = down_table($user_key , $day);
                return facebook( $user_key,"$data[0]\\n============\\n$data[1]",$basic);
                exit;
            }
        }
        if(strpos($message , "날씨") !== false){ // 날씨
            if($message == "날씨"){
                return facebook( $user_key,"날짜를 선택해 주세요",array("오늘 날씨", "내일 날씨", "모레 날씨"));
                exit;
            }
            if(preg_match("/^오늘|내일|모레 날씨$/", $message)){
                $text = str_replace(" 날씨","", $message);
                if($text == "오늘") $day = 0;
                if($text == "내일") $day = 1;
                if($text == "모레") $day = 2;
    
                $data = down_weather($day);
                return facebook( $user_key,"$data[0]\\n============\\n$data[1]",$basic);
                exit;
            }
        }
        return facebook( $user_key,"잘못된 입력입니다",$basic);
        exit;
    }
?>