<?php

//Verification of account
require 'db.php';
session_start();

// Check if hash and email not empty
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);
    
    //Select user account to activate
    $result = $mysqli->query("SELECT * FROM accounts WHERE email='$email' AND hash='$hash' AND active='0'");
    
    if ($result->num_rows == 0) {
        $_SESSION['message'] = "Konto zostało jest już aktywny lub link jest błędny!"; 
        header("location: ../error.php");
    }
    else {
        //Set account status to active
        $mysqli->query("UPDATE accounts SET active='1' WHERE email='$email'") or die($mysqli->error);
        $_SESSION['active'] = 1;
        $_SESSION['message'] = "Aktywacja twoje konta powiodła się!";
        header("location: ../index.php");
    }
}


