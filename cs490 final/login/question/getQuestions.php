<?php
    $con = mysql_connect("sql.njit.edu","ovl2_proj","cs490");
    if(!$con) {
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db("ovl2_proj", $con);
    
    $sqlMC = mysql_query("SELECT Question, QuestionNum  FROM MultipleChoice");
    $sqlTF = mysql_query("SELECT Question, QuestionNum FROM TrueFalse");
    $sqlOE = mysql_query("SELECT Question, QuestionNum FROM OpenEnded");
    
    $sqlEasy = mysql_query("SELECT Question, QuestionNum FROM MultipleChoice WHERE Difficulty='Easy' UNION SELECT Question, QuestionNum FROM TrueFalse WHERE Difficulty='Easy' UNION SELECT Question, QuestionNum FROM OpenEnded WHERE Difficulty='Easy'");
    $sqlMedium = mysql_query("SELECT Question, QuestionNum FROM MultipleChoice WHERE Difficulty='Medium' UNION SELECT Question, QuestionNum FROM TrueFalse WHERE Difficulty='Medium' UNION SELECT Question, QuestionNum FROM OpenEnded WHERE Difficulty='Medium'");
    $sqlHard = mysql_query("SELECT Question, QuestionNum FROM MultipleChoice WHERE Difficulty='Hard' UNION SELECT Question, QuestionNum FROM TrueFalse WHERE Difficulty='Hard' UNION SELECT Question, QuestionNum FROM OpenEnded WHERE Difficulty='Hard'");

    $MCquestions = array();
    $TFquestions = array();
    $OEquestions = array();
    
    while($mc = mysql_fetch_assoc($sqlMC)) {
            $MCquestions[] = $mc;
    }
    
    while($tf = mysql_fetch_assoc($sqlTF)) {
            $TFquestions[] = $tf;
    }
    
    while($oe = mysql_fetch_assoc($sqlOE)) {
            $OEquestions[] = $oe;
    }
    
    $Easyquestions = array();
    $Mediumquestions = array();
    $Hardquestions = array();
    
    while($e = mysql_fetch_assoc($sqlEasy)) {
            $Easyquestions[] = $e;
    }
    
    while($m = mysql_fetch_assoc($sqlMedium)) {
            $Mediumquestions[] = $m;
    }
    
    while($h = mysql_fetch_assoc($sqlHard)) {
            $Hardquestions[] = $h;
    }
    
    //echo json_encode($MCquestions);
    //echo json_encode($TFquestions);
    
    $Qus = json_encode(array('MultipleChoice' => $MCquestions, 'TrueFalse' => $TFquestions, 'OpenEnded' => $OEquestions, 'Easy' => $Easyquestions, 'Medium' => $Mediumquestions, 'Hard' => $Hardquestions));
    //echo $Qus;
    
    $crl = curl_init();
    //curl_setopt($crl, CURLOPT_URL, "http://web.njit.edu/~rab25/CS490/Middle/getQuestions.php");
    curl_setopt($crl, CURLOPT_URL, "http://web.njit.edu/~ic35/CS490/login/teacher/quiz.php");
    curl_setopt($crl, CURLOPT_POST, 1);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $Qus);
    curl_setopt($crl, CURLOPT_FOLLOWLOCATION, 1);
    
    $outputDB = curl_exec($crl);
    curl_close($crl); 
?>