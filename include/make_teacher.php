<?php

session_start();
require 'db.php';

//Get user ID
$id = $mysqli->escape_string($_GET['id']);

//Check if logged user have rights to change role
if (isset($_SESSION['logged_in']) AND isset($_SESSION['role']) AND $_SESSION['role'] == 'admin') {
    $query = "UPDATE accounts SET `role`='teacher' WHERE `id`='$id'";
    if ($mysqli->query($query)) {
        $_SESSION['message'] = "Użytkownikowi $id nadano uprawnienia nauczyciela";
        header("location: ../administration_accounts.php");
    } else {
        $_SESSION['message'] = "Sprawdź połączenie z bazą!";
        header("location: ../administration_accounts.php");
    }
} else {
    $_SESSION['message'] = "Nie masz uprawnień do takich działań!";
    header("location: ../administration_accounts.php");
}