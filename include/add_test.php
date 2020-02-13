<?php

session_start();
require 'db.php';

//Adding a new test
//Set temporary variables
$_SESSION['name_temp'] = $_POST['name'];
$_SESSION['info_temp'] = $_POST['info'];

//Protection against SQL injections
$name = $mysqli->escape_string($_POST['name']);
$info = $mysqli->escape_string($_POST['info']);

//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Check if user have permission (teacher or admin)
if ($user['role'] != "admin" AND $user['role'] != "teacher") {
    //Unset temporary variables
    unset($_SESSION['name_temp']);
    unset($_SESSION['info_temp']);
    $_SESSION['message'] = "Nie masz uprawnień do dodawania testów!";
    header("location: ../index.php");
} else if (empty($_POST['name'])) {
    $_SESSION['empty_name'] = "To pole nie może być puste!";
    header("location: ../add_test_page.php");
} else {
    $sql = "INSERT INTO tests (name,info) VALUES ('$name','$info')";

    if ($mysqli->query($sql)) {
        //Unset temporary variables
        unset($_SESSION['name_temp']);
        unset($_SESSION['info_temp']);

        $_SESSION['message'] = "Nowy test został dodany poprawnie!";
        header("location: ../administration_tests.php");
    } else {
        $_SESSION['message'] = "Ups, coś poszło nie tak! ";
        header("location: ../add_test_page.php");
    }
}

