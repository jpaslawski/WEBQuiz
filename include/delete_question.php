<?php

session_start();
require 'db.php';

//Protection against SQL injections
$id = $mysqli->escape_string($_GET['id']);


//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Check if user have permission (teacher or admin)
if ($user['role'] != "admin" AND $user['role'] != "teacher") {
    //Unset temporary variables
    unset($_SESSION['question_temp']);
    unset($_SESSION['answerA_temp']);
    unset($_SESSION['answerB_temp']);
    unset($_SESSION['answerC_temp']);
    unset($_SESSION['answerD_temp']);
    $_SESSION['message'] = "Nie masz uprawnień do usuwania pytań!";
    header("location: ../index.php");
} else {
    //Get question
    $queryQuestion = $mysqli->query("SELECT * FROM questions WHERE id='$id'");
    $question = $queryQuestion->fetch_assoc();
    
    //First delete all question association
    $queryTestAssociated = "DELETE FROM test_question WHERE `question_id`='$id'";
    
    //Then delete question
    $sql = "DELETE FROM questions WHERE `id`='$id'";

    if ($mysqli->query($queryTestAssociated) AND $mysqli->query($sql)) {
        if (!empty($question['file_name'])) {
            unlink("../additionalFiles/" . $question['file_name']);
        }
        
        $_SESSION['message'] = "Pytanie zostało usunięte!";
        header("location: ../administration_questions.php");
    } else {
        $_SESSION['message'] = "Zapytanie do bazy danych nie zostało wykonane! ";
        header("location: ../delete_question_page.php?id=" . $_GET['id']);
    }
}