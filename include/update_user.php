<?php

session_start();
require 'db.php';

//Update user account information
//Protection against SQL injections
$first_name = $mysqli->escape_string($_POST['first_name']);
$last_name = $mysqli->escape_string($_POST['last_name']);
$index = $mysqli->escape_string($_POST['index']);

//Get user email
$email = $_SESSION['email'];

//Get user from database
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'") or die($mysqli->error());

//Check if any field is empty
if (empty($_POST['first_name'])) {
    $_SESSION['empty_fn'] = "To pole nie może być puste!";
    header("location: ../register_page.php");
} else if (empty($_POST['last_name'])) {
    $_SESSION['empty_ln'] = "To pole nie może być puste!";
    header("location: ../register_page.php");
}
//check if index is integer of 6 digits
else if ((strlen($index) != 6) || (!ctype_digit($index))) {

    $_SESSION['index_error'] = "Podany format jest niepoprawny!";
    header("location: ../update_user_page.php");
} else {
    $sql = "UPDATE accounts SET `first_name`='$first_name', `last_name`='$last_name'"
            . ", `index`='$index' WHERE `email`='$email'";

    if ($mysqli->query($sql)) {
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['index'] = $index;

        //Configure mail message
        $_SESSION['message'] = "Twoje konto zostało zaktualizowane!";
        header("location: ../profile.php");
    } else {
        $_SESSION['message'] = 'Aktualizacja konta nie powiodła się!';
        header("location: ../update_user_page.php");
    }
}

