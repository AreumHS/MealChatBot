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
    //up_class("2학년 12반", "koder");
    //down_class('koder');
    //up_message("설정", "koder");
    //down_message("koder");
    //up_diary("알림장 테스트", "koder")
    //down_diary("koder");
?>