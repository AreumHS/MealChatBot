<?php
    function kakao_reply($message , $user_key){
        
        include "chat.php";
        include "database.php";
        
        $basic = array("급식", "시간표", "알림장", "날씨", "설정");
        $blacklist = "test";
        $class = down_class($user_key);
        $class_setting = array("학년/반 설정");
        
        $last = down_message($user_key);     
        up_message($message , $user_key);
        
        kakao("======================",0,0,0);
        exit;
        
        
        /*if(strpos($blacklist , $user_key) || $last == $message){ // 블랙리스트 처리
            kakao("도배 감지됨",0,0,array(NULL));
            exit;
        }*/
        if($class == NULL && $message != "학년/반 설정" && $last != "학년/반 설정"){
            kakao("학년/반을 먼저 설정해주세요",0,0,$class_setting);
            exit;
        }
        
        if(strpos($message , "설정") !== NULL || $last == "알림장 설정" || $last == "학년/반 설정"){ // 설정
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
        if($message == "급식"){ // 급식
            $data = down_meal();
            
            exit;
        }
        if($message == "알림장"){ // 알림장
            
        }
        if($message == "시간표"){ // 시간표
            
        }
        if($message == "날씨"){ // 날씨
            
        }
    }
    

    function facebook_reply(){
        
    }
?>