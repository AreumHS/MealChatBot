<?php
    function table($class , $days){
        
        date_default_timezone_set("Asia/Seoul");
        $time = date("w" , strtotime("+$days day"));
        
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
        
        $class = trim($class);
        $grade = substr($class, 0, 1);
        $fp = fopen("/storage/ssd4/847/5249847/public_html/chatbot/areum_middle/data/table/$grade/$class.txt", "r");
        if($fp == NULL) return '\\n저장된 시간표 없음';
        
        $text = fread($fp , 4096);
        $text = strstr($text, "제");
        $text = str_replace("\t", "<br/>", $text);
        $text = str_replace("\n", "", $text);
        $text = preg_replace('/\r\n|\r|\n/',' / ',$text);
        $text = preg_replace($pattern, " ", $text);
        $text = preg_split('/[0-9]\([0-9]{1,3}:[0-9]{1,3}\)/',$text);// 1교시~8교시
        
        for($i = 1; $i < 8; $i++){//1~7까지 반복 + 공백 하나
            $tmp = explode("<br/>", $text[$i]);//  1(월) ~ 5(금)
            //print_r($tmp[1]."<br/>" );
            for($j = 1; $j < 6; $j++){
                if($tmp[$j] == NULL) continue;
                
                $day[$j] = $day[$j]."\\n".$tmp[$j];
            }
        }
        if($day[$time] == NULL) return "\\n수업 없음";
        return $day[$time];
    }
?>
