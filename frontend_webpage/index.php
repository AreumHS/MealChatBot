<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<style>
    body{
        margin: 0;
        padding: 0;
        border: 0;
        background-color: #080810;
        color: #FFF;
    }
    .list{
        max-width: 320px;
        padding: 8px 32px;
        box-sizing: border-box;
        background-color: white;
        color: black;
        border-radius: 16px;
        margin: 16px auto 16px auto;
    }
    .title{
        width: 100%;
        text-align: center;
        background-color: #040408;
        display: table;
    }
    .title h1{
        margin: 32px;
    }
    h2{
        margin: 6px 0px;
    }
    .identify{
        background-color: #040408;
        color: white;
        width: 160px;
        text-align: center;
    }
</style>
<?php
    //error_reporting(E_ALL);
    //ini_set("display_errors", 1);

    $date = date("Ymd", time());
    $ScCode = 'I10';
    $SdCode = '9300117';
    $grade = NULL;
    $class = NULL;

    $grade = $_GET['g'];
    $class = $_GET['c'];

    if($grade == NULL) $grade = 1;
    if($class == NULL) $class = 2;

    $table = [];
    $meal = [];
    require("Snoopy.class.php");

    // 시간표 api 받아오기
    $URL = "https://open.neis.go.kr/hub/hisTimetable?KEY=fc1214b4b3844ebe865233e7cf37f20d&Type=json&ATPT_OFCDC_SC_CODE=$ScCode&SD_SCHUL_CODE=$SdCode&ALL_TI_YMD=$date&GRADE=$grade&CLASS_NM=$class";
    $snoopy = new Snoopy; // snoopy 생성
    $snoopy->fetch($URL);
    $return = json_decode($snoopy->results);
    $max = (int)$return->hisTimetable[0]->head[0]->list_total_count;
    for($i=1; $i<=$max; $i++) $table[$i] = $return->hisTimetable[1]->row[$i-1]->ITRT_CNTNT;

    $URL = "https://open.neis.go.kr/hub/mealServiceDietInfo?KEY=fc1214b4b3844ebe865233e7cf37f20d&Type=json&ATPT_OFCDC_SC_CODE=$ScCode&SD_SCHUL_CODE=$SdCode&MLSV_YMD=$date";
    $snoopy = new Snoopy; // snoopy 생성
    $snoopy->fetch($URL);
    $return = json_decode($snoopy->results);
    $meal = explode("<br/>", $return->mealServiceDietInfo[1]->row[0]->DDISH_NM);

?>
<div class="title"><h1>우리반 시간표/급식</h1></div>
<div class="table list">
    <h1 class="identify">시간표</h1>
    <?php for($i=1; $i<=$max; $i++){ echo '<h2>'.$i.'교시 | '.$table[$i].'</h2><br/>'; } ?>
</div>
<div class="meal list">
    <h1 class="identify">급식</h1>
    <?php for($i=0; $i<sizeof($meal); $i++){ echo '<h2>'.preg_replace("/[0-9,.]/", "", $meal[$i]).'</h2><br/>'; } ?>
</div>