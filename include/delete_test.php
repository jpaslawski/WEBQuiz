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

    $_SESSION['message'] = "Nie masz uprawnień do usuwania testów!";
    header("location: ../index.php");
} else {
    //First delete all test association
    $queryQuestionAssociated = "DELETE FROM test_question WHERE `test_id`='$id'";
    $sql = "DELETE FROM tests WHERE `id`='$id'";

    if ($mysqli->query($queryQuestionAssociated) AND $mysqli->query($sql)) {
        $_SESSION['message'] = "Test został usunięty!";
        header("location: ../administration_tests.php");
    } else {
        $_SESSION['message'] = "Ups, coś poszło nie tak! ";
        header("location: ../delete_test_page.php?id=" . $id);
    }
}