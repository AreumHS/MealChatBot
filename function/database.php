<?php
    function down_class($user_key){
        $host = 'localhost';
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';
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
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';    
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
        $data = down_class($user_key);
        $grade = $data[0];
        $class = $data[1];
        
        $host = 'localhost';
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';
        
        try{
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="SELECT * FROM diary";//mysql 구문
            
            $st = $pdo->prepare($sql);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_BOTH);
            
            while($row = $st->fetch()){
                if($row[0] == $grade && $row[1] == $class){ // 저장된 학급 데이터 불러오기 성공.
                    return $row[2];
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
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';

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
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';
        
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
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';
        
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
    
    function down_meal($days){
        date_default_timezone_set("Asia/Seoul");
        
        $host = 'localhost';
        $db = 'id7485398_koderapp';
        $user = 'id7485398_koder';
        $pass = 'codingslave';
        
        $data = NULL;
        $realdate = date("Y-m-d");
        $date = date("Y.m.d", strtotime("+$days days")); //nice  파싱을 위한 시간
        $time = date("Y-m-d", strtotime("+$days days")); //mysql 연동을 위한 시간
        
        

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
                $day=0; // weekday number를 가져옴
                if ( date('w')+$days > 6) {   $day = (date('w')+$days)-7;    } else {    $day = date('w')+$days;    }

                $final=$final[0][$day]; // 해당 날의 급식을 가져옴
                $final=preg_replace("/[0-9]/", "", $final);  // 숫자 제거(정규식이용)
                $array_filter = array('.', ' ', '<tdclass="textC">', '</td>');  // 필터
                foreach ($array_filter as $filter) {  $final=str_replace($filter, '', $final);  }
                $final=str_replace('<br/>', '\\n', $final); // br => 개행
                $final=substr($final, 0, -2); // 마지막 줄 개행문자 없애기
                if ( strcmp($final, '') == false ){  $final = "급식이 없습니다.";  } //급식이 없는경우
                $date = str_replace(".","-",$date);

                $return = array($date, $final); // 해당날짜, 급식메뉴

                $sql = "INSERT INTO meal VALUES('$date','$final')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $return;
            }
        }
        catch(Exception $e) {    echo 'Failed to obtain database handle : '.$e->getMessage();    }//오류/에러처리
        $pdo = NULL;
    }
    
    function down_table($user_key){
        
    }
    //up_class("2학년 12반", "koder");
    //down_class('koder');
    //up_message("설정", "koder");
    //down_message("koder");
    //up_diary("알림장 테스트", "koder")
    //down_diary("koder");
?>