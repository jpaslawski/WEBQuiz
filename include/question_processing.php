<?php

session_start();

include 'db.php';

//Get values from SESSION
$arrayQuestions = $_SESSION['arrayQuestions'];
$questionNumber = $mysqli->escape_string($_SESSION['questionNumber']);
$test_id = $mysqli->escape_string($_SESSION['test_id']);
$questionAmount = $_SESSION['questionAmount'];
$email = $_SESSION['email'];

//Get other values
$answer = $mysqli->escape_string($_GET['answer']);

if (isset($_SESSION['arrayAnswers'])) {
    $arrayAnswers = $_SESSION['arrayAnswers'];
} else {
    $arrayAnswers[$questionNumber] = $answer;
}

//Put answer in array
$arrayAnswers[$questionNumber] = $answer;
$_SESSION['arrayAnswers'] = $arrayAnswers;

//Set next question
$questionNumber++;

//Check if there are more questions
if ($questionNumber != $questionAmount) {
    $_SESSION['questionNumber'] = $questionNumber;
    header("location: ../answer_question_page.php");
} else {

    //Get user
    $result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'") or die($mysqli->error());
    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    //Get all answers
    for ($i = 0; $i < $questionAmount; $i++) {
        $queryAnswers = $mysqli->query("SELECT * FROM questions WHERE id='$arrayQuestions[$i]'");
        $answer = $queryAnswers->fetch_assoc();
        $rightAnswers[$i] = $answer['right_answer'];
    }
    $_SESSION['rightAnswers'] = $rightAnswers;

    //Calculate user result
    $points = 0;
    for ($i = 0; $i < $questionAmount; $i++) {
        if ($arrayAnswers[$i] == $rightAnswers[$i]) {
            $points++;
        }
    }
    
    //Send user result to database
    //Get test name
    $queryTest = $mysqli->query("SELECT * FROM tests WHERE id='$test_id'") or die($mysqli->error());
    $test = $queryTest->fetch_assoc();
    $test_name = $test['name'];
    
    $percentage = round($points / $questionAmount, 2) * 100 . "%";
    $date_added = date("Y.m.d h:m:s");
    $mysqli->query("INSERT INTO results (test_name, user, percentage, date_added) "
                . "VALUES ('$test_name','$user_id','$percentage','$date_added')");
    
    $_SESSION['points'] = $points;

    header("location: ../end_test_page.php");
}