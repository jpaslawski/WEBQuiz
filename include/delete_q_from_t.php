<?php

session_start();
require 'db.php';

//Protection against SQL injections
$question_id = $mysqli->escape_string($_GET['question_id']);
$test_id = $mysqli->escape_string($_GET['test_id']);

//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Check if user have permission (teacher or admin)
if ($user['role'] != "admin" AND $user['role'] != "teacher") {

    $_SESSION['message'] = "Nie masz uprawnień do usuwania testów!";
    header("location: ../index.php");
} else {
    $sql = "DELETE FROM test_question WHERE `question_id`='$question_id' AND `test_id`='$test_id'";

    if ($mysqli->query($sql)) {
        $_SESSION['message'] = "Pytanie zostało usunięte z testu!";
        header("location: ../test_details_page.php?id=" . $test_id);
    } else {
        $_SESSION['message'] = "Ups, coś poszło nie tak! ";
        header("location: ../test_details_page.php?id=" . $test_id);
    }
}