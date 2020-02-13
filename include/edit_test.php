<?php

session_start();
require 'db.php';

//Protection against SQL injections
$id = $mysqli->escape_string($_GET['id']);
$name = $mysqli->escape_string($_POST['name']);
$info = $mysqli->escape_string($_POST['info']);

//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Check if user have permission (teacher or admin)
if ($user['role'] != "admin" AND $user['role'] != "teacher") {

    $_SESSION['message'] = "Nie masz uprawnień do edytowania testów!";
    header("location: ../index.php");
}
//check if name is empty
else if (empty($_POST['name'])) {
    $_SESSION['empty_name'] = "To pole nie może być puste!";
    header("location: ../edit_test_page.php");
} else {
    $sql = "UPDATE tests SET `name`='$name', `info`='$info' WHERE `id`='$id'";

    if ($mysqli->query($sql)) {

        $_SESSION['message'] = "Test został zaktualizowany!";
        header("location: ../administration_tests.php");
    } else {
        $_SESSION['message'] = "Ups, coś poszło nie tak! ";
        header("location: ../edit_test_page.php?id=" . $_GET['id']);
    }
}

