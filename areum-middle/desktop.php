<?php
    include "function/database.php";
    error_reporting(0); 

    $grade = $class = NULL;
    $day = 0;

    $grade = $_GET['grade'];
    $class = $_GET['class'];

    echo '<h1>'.$grade.'학년 '.$class.'반</h1>';

    if($grade == NULL && $class == NULL){
        echo '
            <div id="data"  action = "/">
                먼저 학년반을 골라 주세요.
                <hr/>
                <form>
                    <select name="grade">
                        <option value="">학년</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        
                    </select>
                    <select name="class">
                        <option value="">반</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                    </select>

                    <input type="submit">
                </form>

            </div>
        ';
    }
    
    $meal = down_meal($day);
    
    $diary= down_diary("desktop".$grade.$class);
    
    $table= down_table("desktop".$grade.$class, $day);
    

    
?>
<style>
    body{
        vertical-align: middle;
        text-align: center;
        background-color: #BBB;
    }
    h1,
    #data{
        margin: auto;
        padding : 15px;
        width: 500px;
        background-color: #444;
        color: #FFF;
        margin-bottom: 16px;
    }
    hr{
        border: 1px solid #BBB;
        width: 400px;
    }
</style>
<body>
    <div id="data"><?php echo $meal[0]."<br/><hr/>".str_replace('\n', '<br/>', $meal[1]);?></div>
    <div id="data"><?php echo $table[0]."<br/><hr/>".str_replace('\n', '<br/>', $table[1]);?></div>
    <div id="data"><?php echo $diary[0]."<br/><hr/>".str_replace('\n', '<br/>', $diary[1]);?></div>
</body>