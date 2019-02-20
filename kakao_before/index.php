<style>
    body{
        color : #FFFFFF;
        background-color: #202020;
    }
    button,
    textarea,
    input{
        background-color: #404040; border: 0px;
        color: #FFFFFF;
    }
</style>
<a href="" style="text-decoration:none; color:white;">
<h1 style="text-align : center;">
    <?php
        $class = $_GET["class"];
        if($class == NULL || $class == 0){    exit;    }
        $data = substr($class, 0,1) . " 학년 " . substr($class,1,2) . " 반";
        echo $data;
        $password = $_POST["password"];
        if($password == NULL || $password == 0)
    ?>
</h1>
</a>
<div style="border: 2px solid #202020; background-color: #404040;  width: 97.6%; height: auto; padding:1%;">
    <h2>
        <?php
            $password = $_POST["password"];
            $input = $_POST["input"];
            
            if(!($input == NULL || $password == NULL)){
                if($password == "passwd");
                
                $fp = fopen("word.txt", "rb");
                $pattern = fread($fp, 8192);
                $pattern = explode("\n", $pattern);
                $input = str_replace($pattern, "***", $input);
                fclose($fp);
                
                $fp = fopen("./chatbot/areum_middle/data/diary/$class.txt", "w");
                fwrite($fp, $input);
                fclose($fp);
                
                echo "설정된 알림장은 <br/>". str_replace("\n", "<br/>", $input);
                
            }
        ?>
    </h2>
</div>

<div style="">
    <div style="border:2px solid #202020; background-color:#404040; float:left; width:31%; height:60%; padding:1%;">
        <h2>
            <?php
                include "./chatbot/areum_middle/function/meal.php";
                $meal = getmeal(0);
                echo $meal[0] . "의 급식 <br/></h2><h3>";
                echo "<br/>";
                echo str_replace("\\n", "<br/>", $meal[1]);    
            ?>
        </h3>
    </div>
    <div style="border:2px solid #202020; background-color:#404040; float:left; width:31%; height:60%; padding:1%;">
        <h2>
            <?php
                include "./chatbot/areum_middle/function/diary.php";
                echo $data ."의 알림장<br/></h2><h3>";
                echo "<br/>";
                echo str_replace("\\n", "<br/>", diary($class));
            ?>
        </h3>
    </div>
    <div style="border:2px solid #202020; background-color:#404040; float:left; width:31%; height:60%; padding:1%;">
        <h2>
            <?php
                include "./chatbot/areum_middle/function/table.php";
                echo $meal[0] ."의 시간표<br/></h2><h3>";
                echo str_replace("\\n", "<br/>", table($class , 0));
            ?>
        </h3>
    </div>
</div>

<form action="" method="post">
  비밀번호:<br>
  <input type="password" name="password"><br>
  알림장 내용<br>
  <textarea name="input" style="width: 100%; height: 20%"></textarea><br/>
  <button type="submit">제출</button>
</form>



