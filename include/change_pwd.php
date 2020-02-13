<?php
session_start();
require 'db.php';
//Changing user account password
//Unset errors
unset($_SESSION['password_error']);
unset($_SESSION['new_password_error']);

//Protection against SQL injections
$current_password = $mysqli->escape_string(password_hash($_POST['current_password'], PASSWORD_BCRYPT));
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$re_password = $mysqli->escape_string(password_hash($_POST['re_password'], PASSWORD_BCRYPT));

//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Check if password field is empty
if (empty($_POST['password'])) {
    $_SESSION['empty_password'] = "Musisz wpisać jakieś hasło!";
    header("location: ../change_pwd_page.php");
}
//Check if given current password is right
else if (!password_verify($_POST['current_password'], $user['password'])) {
    $_SESSION['password_error'] = "Hasło, które podałeś jest niepoprawne!";
    header("location: ../change_pwd_page.php");
}
//new passwords don't match
else if ($_POST['password'] != $_POST['re_password']) {
    $_SESSION['new_password_error'] = 'Podane hasła się nie zgadzają!';
    header("location: ../change_pwd_page.php");
}
else {
    $sql = "UPDATE accounts SET `password`='$password' WHERE `email`='$email'";
    
    if ($mysqli->query($sql)) {
        $_SESSION['message'] = "Twoje hasło zostało zaktualizowane!";
        header("location: ../profile.php");
    }
    else {
        $_SESSION['message'] = 'Aktualizacja hasła nie powiodła się!';
        header("location: ../change_pwd_page.php");
    }
}