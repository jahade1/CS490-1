<?php
    $con = mysql_connect("sql.njit.edu","ovl2_proj","cs490");
    if(!$con) {
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db("ovl2_proj", $con);
    
    $request = file_get_contents('php://input');
    $recieve = json_decode($request);
    
    $Question = $recieve->Question;
    $Opt1 = $recieve->Opt1;
    $Opt2 = $recieve->Opt2;
    $Opt3 = $recieve->Opt3;
    $Opt4 = $recieve->Opt4;
    $Answer = $recieve->Answer;
    $Type = $recieve->Type;
    
    if ($Type == 'MC') {
       //echo 'MC';
       $createMC = "INSERT INTO MultipleChoice (Question, Opt1, Opt2, Opt3, Opt4, Answer) VALUES ('$Question', '$Opt1', '$Opt2', 'Opt3', 'Opt4', '$Answer')";
       $exec = mysql_query($createMC, $con);
       echo "Question Added.";
       //header ("Location: http://web.njit.edu/~ovl2/CS490/Front/createQuestions.html");
    }
    
    if ($Type == 'TF') {
        //echo 'TF';
        $createTF = "INSERT INTO TrueFalse (Question, Opt1, Opt2, Answer) VALUES ('$Question', '$Opt1', '$Opt2', '$Answer')";
        $exec1 = mysql_query($createTF, $con);
        echo "Question Added.";
        //header ("Location: http://web.njit.edu/~ovl2/CS490/Front/createQuestions.html");
    }
    
    if ($Type == 'OE') {
        //echo 'OE';
        $createOE = "INSERT INTO OpenEnded (Question) VALUES ('$Question')";
        $exec2 = mysql_query($createOE, $con);
        echo "Question Added.";
        //header ("Location: http://web.njit.edu/~ovl2/CS490/Front/createQuestions.html");
    } 
?>