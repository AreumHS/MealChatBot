<?php
function getweather($day)
{
  header("Content-type: application/json; charset=UTF-8");
  require("Snoopy.class.php");
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
  
  $list_filter = array('<temp>', '</temp>', '<tmx>', '</tmx>', '<tmn>', '</tmn>',
  '<sky>', '</sky>', '<pty>', '</pty>', '<wfKor>', '</wfKor>',
  '<pop>', '</pop>', '<reh>', '</reh>', '<hour>', '</hour>');
  
  foreach ($list_filter as $filter) { // 필터링
      $temp = str_replace($filter, '', $temp);
      $sky = str_replace($filter, '', $sky);
      $pty = str_replace($filter, '', $pty);
      $wfKor = str_replace($filter, '', $wfKor);
      $pop = str_replace($filter, '', $pop);
      $reh = str_replace($filter, '', $reh);
      $hour = str_replace($filter, '', $hour);
  }

  $return[0] = "온도 : " . $temp . "\\n";
  $return[1] = "하늘 : " . $sky . "\\n";
  $return[2] = "날씨 : " . $wfKor . "\\n";
  $return[3] = "강수 : " . $pop . "%\\n";
  $return[4] = "습도 : " . $reh . "%\\n";
  $return[5] = $hour/12 <= 1 ? 'AM ' : 'PM ' ; 
  $return[5] .= $hour%12 ."시의 날씨 예보";
  $return[6] = $wfKor; // 그림 출력을 위해서 날씨 값도
  return $return;
}

function weather($day){
  $final = getweather($day);
  $weather = $final[6];
  $final = $final[0] . $final[1] . $final[2] . $final[3] . $final[4] . $final[5];
  $pic_url = "http://areum.000webhostapp.com/chatbot/areum_middle/asset/image/";
  
  if (strcmp($weather, "맑음") == false)        {    $pic_url = $pic_url . "sun.jpg";     }
  else if ( strpos($weather, "구름") !== false ){    $pic_url = $pic_url . "cloud.jpg";   }
  else if (strcmp($weather, "흐림") == false)   {    $pic_url = $pic_url . "mist.jpg";    }
  else if ( strpos($weather, "비") !== false )  {    $pic_url = $pic_url . "rain.jpg";    }
  else if (strcmp($weather, "눈") == false)     {    $pic_url = $pic_url . "snow.jpg";    }
  $return[0] = $final;
  $return[1] = $pic_url;
  return $return;
}

?>