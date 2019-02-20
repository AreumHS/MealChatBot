<?php
    function diary($class){
        $class = preg_replace("/[^0-9]/", "", $class);
        $fp = fopen("/storage/ssd4/847/5249847/public_html/chatbot/areum_middle/data/diary/$class.txt", "rb");
        if(!$fp) return '알림장이 정해지지 않았습니다';
        $arr = fread ( $fp , 4096);
        if($arr == NULL) return '알림장에 내용이 없습니다';
        $text = str_replace("\n", '\\n' , $arr);
        $text = preg_replace('/\r\n|\r|\n/','',$text);
        fclose($fp);
        return $text;
    }
    //http://areum.000webhostapp.com/test/data/diary/diary$class.txt
?>