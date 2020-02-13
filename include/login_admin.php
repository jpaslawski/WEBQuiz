<?php
require 'db.php';
session_start();

//Login for Admin and teacher
//Protection against SQL injections
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");


if ($result->num_rows == 0) {
    $_SESSION['email_error'] = "Konto z takim emailem nie istnieje!";
    header("location: ../admin.php");
}
else {
    $user = $result->fetch_assoc();
    if ($user['role'] != 'admin' AND $user['role'] != 'teacher') {
        $_SESSION['email_error'] = "Użytkownik z takim mailem nie jest upoważniony do logowania na tej stronie!";
        header("location: ../admin.php");
    }
    else if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['index'] = $user['index'];
        $_SESSION['active'] = $user['active'];
        $_SESSION['role'] = $user['role'];
        
        //Set logged in user
        $_SESSION['logged_in'] = true;
        
        $_SESSION['message'] = "Witaj na stronie administracji!";
        header("location: ../administration_panel.php");
    }
    else {
        $_SESSION['password_error'] = "Hasło niepoprawne, spróbuj ponownie!";
        header("location: ../admin.php");
    }
}