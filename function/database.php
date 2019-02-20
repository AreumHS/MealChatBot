<?php
    //up_class("2학년 12반", "koder");
    //down_class('koder');
    //up_message("설정", "koder");
    //down_message("koder");
    //up_diary("알림장 테스트", "koder");
    //down_diary("koder");
    //down_meal(0);
    //down_weather(0);
    //down_table("koder", 3);

    function down_class($user_key){
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="SELECT * FROM student";//mysql 구문
            
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $user_key){ // 저장된 학급 데이터 불러오기 성공.
                    $grade = $row[1];
                    $class = $row[2];
                    return array($grade , $class);
                }
            }
            return NULL;
        }
        catch(Exception $e) {    echo 'Database Error : '.$e->getMessage();    }//오류||에러처리
        $pdo = NULL;
        return 0;
    }
    
    function up_class($message , $user_key){
        $grade = substr(preg_replace("/[^0-9]*/s", "", $message), 0, 1);
        $class = substr(preg_replace("/[^0-9]*/s", "", $message), 1, 2);
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';    
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql="SELECT * FROM student";
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $user_key){ // 수정
                    $sql = "UPDATE student SET grade = $grade , class = $class WHERE user_key = '$user_key';";
                    $st = $pdo->prepare($sql);
                    $st->execute();
                    $st->setFetchMode(PDO::FETCH_BOTH);
                    return 1;
                }
            } // 생성
            $sql = "INSERT INTO `student` VALUE ('$user_key' , $grade , $class)";
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            return 1;
        }
        catch(Exception $e) {    echo 'Database Error : '.$e->getMessage();    }//오류||에러처리
        $pdo = NULL;
        return 0;
    }
    
    function down_diary($user_key){
        if(preg_match("/desktop[0-9]{3}/", $user_key)){ // 데스크탑에서 호출됨.
            $data = preg_replace("/[^0-9]/", "", $user_key);
            $grade= substr($data,0,1);
            $class= substr($data,1,2);
        }else{
            $data = down_class($user_key);
            $grade = $data[0];
            $class = $data[1];
        }
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';
        
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="SELECT * FROM diary";//mysql 구문
            
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $grade && $row[1] == $class){ // 저장된 학급 데이터 불러오기 성공.
                    return array($grade."학년 ".$class."반 알림장" , $row[2]);
                }
            }
            return 1;
        }
        catch(Exception $e) {    echo 'Database Error : '.$e->getMessage();    }//오류||에러처리
        $pdo = NULL;
        return 0;
    }
    
    function up_diary($message , $user_key){
        $data = down_class($user_key);
        $grade = $data[0];
        $class = $data[1];
        
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';

        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql="SELECT * FROM diary";
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $grade && $row[1] == $class){ // 수정
                    $sql = "UPDATE diary SET diary = '$message' WHERE grade = $grade AND class = $class";
                    $st = $pdo->prepare($sql);
                    $st->execute();
                    $st->setFetchMode(PDO::FETCH_BOTH);
                    return 1;
                }
            } // 생성
            $sql = "INSERT INTO `diary` (`grade`, `class`, `diary`) VALUES ('$grade', '$class', '$message')";
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            return 1;
        }
        catch(Exception $e) {    echo 'Database Error : '.$e->getMessage();    }//오류||에러처리
        $pdo = NULL;
        return 0;
    }
    
    function down_message($user_key){
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';
        
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="SELECT * FROM message";//mysql 구문
            
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $user_key){ // 저장된 최근 메시지 불러오기 성공.
                    $last = $row[1];
                    return $last;
                }
            }
            return NULL;
        }
        catch(Exception $e) {    echo 'Database Error : '.$e->getMessage();    }//오류||에러처리
        $pdo = NULL;
        return 0;
    }
    
    function up_message($message , $user_key){
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';
        
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql="SELECT * FROM message";
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $user_key){ // 수정
                    $sql = "UPDATE message SET last = '$message' WHERE user_key = '$user_key';";
                    $st = $pdo->prepare($sql);
                    $st->execute();
                    $st->setFetchMode(PDO::FETCH_BOTH);
                    return 1;
                }
            } // 생성
            $sql = "INSERT INTO `message` VALUE ('$user_key' , '$message')";
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            return 1;
        }
        catch(Exception $e) {    echo 'Database Error : '.$e->getMessage();    }//오류||에러처리
        $pdo = NULL;
        return 0;
    }
    
    function down_meal($day){
        date_default_timezone_set("Asia/Seoul");
        
        $host = 'localhost';
        $db = 'database';
        $user = 'user';
        $pass = 'password';
        
        $data = NULL;
        $realdate = date("Y-m-d");
        $date = date("Y.m.d", strtotime("+$day days")); //nice  파싱을 위한 시간
        $time = date("Y-m-d", strtotime("+$day days")); //mysql 연동을 위한 시간
        
        

        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql="SELECT * FROM meal";//mysql 구문
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);

            while($row = $st->fetch()){
                $data = $data.$row[0].' | ';
                
                if(ceil((strtotime($row[0]) - strtotime($realdate)) / (60*60 *24)) < 0 ){//날짜가 지난 더미데이터 제거
                    $sql = "delete from meal where date = '$row[0]'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                }
                if($row[0] == $time){//이미 저장된 급식이 있음
                    $row[1] = preg_replace('/\r\n|\r|\n/','\\n',$row[1]);
                    return array($time , $row[1]);
                }
            }
            if(strpos($time , $data) == false){//저장된 급식이 없음
                require("Snoopy.class.php");
                $URL = "https://stu.sje.go.kr/sts_sci_md01_001.do?schulCode=I100000108&&schulCrseScCode=3&schMmealScCode=2&schYmd=" . $date;
            
                $snoopy = new Snoopy; // snoopy 생성
                $snoopy->fetch($URL);
                preg_match('/<tbody>(.*?)<\/tbody>/is', $snoopy->results, $tbody); // tbody 추출
                $final=$tbody[0];
                preg_match_all('/<tr>(.*?)<\/tr>/is', $final, $final); // tr 추출

    

                $final=$final[0][1]; // 첫 번째 항목(0)은 급식인원, 두 번째 항목은 식단표(1)이므로
                preg_match_all('/<td class="textC">(.*?)<\/td>/is', $final, $final); // td 추출
                //$day=0; // weekday number를 가져옴
                if ( date('w')+$day > 6) {   $day = (date('w')+$day)-7;    } else {    $day = date('w')+$day;    }

                $final=$final[0][$day]; // 해당 날의 급식을 가져옴
                $final=preg_replace("/[0-9]/", "", $final);  // 숫자 제거(정규식이용)
                $array_filter = array('.', ' ', '<tdclass="textC">', '</td>');  // 필터
                foreach ($array_filter as $filter) {  $final=str_replace($filter, '', $final);  }
                $final=str_replace('<br/>', '\\n', $final); // br => 개행
                $final=substr($final, 0, -2); // 마지막 줄 개행문자 없애기
                if ( strcmp($final, '') == false ){  $final = "급식이 없습니다.";  } //급식이 없는경우

                $return = array($time, $final); // 해당날짜, 급식메뉴

                $sql = "INSERT INTO meal VALUES('$time','$final')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $return;
            }
        }
        catch(Exception $e) {    echo 'Failed to obtain database handle : '.$e->getMessage();    }//오류/에러처리
        $pdo = NULL;
    }
    
    function down_table($user_key, $day){
        if(preg_match("/desktop[0-9]{3}/", $user_key)){ // 데스크탑에서 호출됨.
            $data = preg_replace("/[^0-9]/", "", $user_key);
            $grade= substr($data,0,1);
            $class= substr($data,1,2);
        }else{
            $data = down_class($user_key);
            $grade = $data[0];
            $class = $data[1];
        }

        date_default_timezone_set("Asia/Seoul");
        $time = date("w" , strtotime("+$day day"));

        $pattern = array(
            '/월\([0-9]{1,3}\)/',
            '/화\([0-9]{1,3}\)/',
            '/수\([0-9]{1,3}\)/',
            '/목\([0-9]{1,3}\)/',
            '/금\([0-9]{1,3}\)/',
            '/토\([0-9]{1,3}\)/',
            '/일\([0-9]{1,3}\)/',
            '/제 [0-9] 학년 [0-9]{1,3} 반 시간표/',
            '/수정일: [0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/',
            '/교시/'
        );

        $fp = fopen("/storage/ssd1/398/7485398/public_html/chatbot/table/$grade/$grade$class.txt", "r");
        if($fp == NULL) return array($grade."학년 ".$class."반 시간표",'저장된 시간표 없음');

        //$text = str_replace("\n", "", $text);
        $text = fread($fp , 4096);
        $text = strstr($text, "제");
        $text = str_replace("\t", "<br/>", $text);
        $text = preg_replace('/\r\n|\r|\n/',' / ',$text);
        $text = preg_replace($pattern, " ", $text);
        $text = preg_split('/[0-9]\([0-9]{1,3}:[0-9]{1,3}\)/',$text);// 1교시~8교시

        for($i = 0; $i < 6; $i++)$days[$i] = NULL;
        
        for($i = 1; $i < 8; $i++){
            $tmp = explode("<br/>", $text[$i]);
            for($j = 1; $j < 6; $j++){
                if($tmp[$j] == NULL) continue;
                $days[$j] .= "\\n".$tmp[$j];
            }
        }
        if($days[$time] == NULL) return array($grade."학년 ".$class."반 시간표","수업 없음");
        return array($grade."학년 ".$class."반 시간표",substr($days[$time].'a', 2, -1));
    }
     
    function down_weather($day){
        require("Snoopy.class.php");
        
        date_default_timezone_set("Asia/Seoul");
        $time = date("Y-m-d", strtotime("+$day days"));

        $URL = "http://www.kma.go.kr/wid/queryDFSRSS.jsp?zone=3611053000"; 
        $snoopy = new Snoopy;
        $snoopy->fetch($URL);

        preg_match('/<body>(.*?)<\/body>/is', $snoopy->results, $body); // body 추출
        $weather_data = $body[0];
        $date = $day * 8; // 가장 최근에 발표된 데이터

        $re = "/<data seq=\"" . $date . "\">(.*?)<\/data>/is";
        preg_match($re, $weather_data, $weather_data);
        $weather_data = $weather_data[0]; 

  

        preg_match('/<hour>(.*?)<\/hour>/is', $weather_data, $hour);  $hour = $hour[0];
        preg_match('/<temp>(.*?)<\/temp>/is', $weather_data, $temp);  $temp = $temp[0];
        preg_match('/<tmx>(.*?)<\/tmx>/is', $weather_data, $tmx);   $tmx = $tmx[0];
        preg_match('/<tmn>(.*?)<\/tmn>/is', $weather_data, $tmn);   $tmn = $tmn[0];
        preg_match('/<sky>(.*?)<\/sky>/is', $weather_data, $sky);   $sky = $sky[0];

        $sky = str_replace(1, '맑음', $sky);
        $sky = str_replace(2, '구름 조금', $sky);
        $sky = str_replace(3, '구름 많음', $sky);
        $sky = str_replace(4, '흐림', $sky);

        preg_match('/<pty>(.*?)<\/pty>/is', $weather_data, $pty); // 강수 상태 코드 => $pty

        $pty = $pty[0];
        $pty = str_replace(0, '없음', $pty);
        $pty = str_replace(1, '비', $pty);
        $pty = str_replace(2, '비/눈', $pty);
        $pty = str_replace(3, '눈/비', $pty);
        $pty = str_replace(4, '눈', $pty);

  

        preg_match('/<wfKor>(.*?)<\/wfKor>/is', $weather_data, $wfKor);   $wfKor = $wfKor[0];
        preg_match('/<pop>(.*?)<\/pop>/is', $weather_data, $pop);   $pop = $pop[0];
        preg_match('/<reh>(.*?)<\/reh>/is', $weather_data, $reh);   $reh = $reh[0];

  

        $list_filter = array(
            '<temp>', '</temp>', '<tmx>', '</tmx>', '<tmn>', '</tmn>',
            '<sky>', '</sky>', '<pty>', '</pty>', '<wfKor>', '</wfKor>',
            '<pop>', '</pop>', '<reh>', '</reh>', '<hour>', '</hour>'
        );

  

        foreach ($list_filter as $filter) { // 필터링
            $temp = str_replace($filter, '', $temp);
            $sky = str_replace($filter, '', $sky);
            $pty = str_replace($filter, '', $pty);
            $pop = str_replace($filter, '', $pop);
            $reh = str_replace($filter, '', $reh);
            $hour = str_replace($filter, '', $hour);
            $wfKor = str_replace($filter, '', $wfKor);
        }

        $return = NULL;
        $return .= "온도 : " . $temp . "\\n";
        $return .= "하늘 : " . $sky . "\\n";
        $return .= "날씨 : " . $wfKor . "\\n";
        $return .= "강수 : " . $pop . "%\\n";
        $return .= "습도 : " . $reh . "%\\n";
        $return .= $hour/12 <= 1 ? 'AM ' : 'PM ';
        $return .= $hour%12 ."시의 날씨 예보"; 
  
        return array($time , $return);
    }
?>