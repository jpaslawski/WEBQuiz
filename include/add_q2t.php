<?php

session_start();
require 'db.php';

//Adding a question to a test
//Protection against SQL injections
$question_id = $mysqli->escape_string($_POST['question']);
$test_id = $mysqli->escape_string($_GET['test_id']);

//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Check if user have permission (teacher or admin)
if ($user['role'] != "admin" AND $user['role'] != "teacher") {
    //Unset temporary variables
    $_SESSION['message'] = "Nie masz uprawnień do dodawania pytań do testów!";
    header("location: ../index.php");
} else {
    $sql = "INSERT INTO test_question (test_id,question_id) VALUES ('$test_id','$question_id')";

    if ($mysqli->query($sql)) {

        $_SESSION['message'] = "Pytanie zostało pomyślnie dodane do testu!";
        header("location: ../test_details_page.php?id=" . $test_id);
    } else {
        $_SESSION['message'] = "Ups, coś poszło nie tak! ";
        header("location: ../add_q2t_page.php");
    }
}

