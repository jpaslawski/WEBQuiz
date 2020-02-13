<?php
session_start();
require 'db.php';
require 'webmailer.php';
//Registration
//Set temporary variables
$_SESSION['email_temp'] = $_POST['email'];
$_SESSION['first_name_temp'] = $_POST['first_name'];
$_SESSION['last_name_temp'] = $_POST['last_name'];

//Protection against SQL injections
$first_name = $mysqli->escape_string($_POST['first_name']);
$last_name = $mysqli->escape_string($_POST['last_name']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$re_password = $mysqli->escape_string(password_hash($_POST['re_password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string(md5(rand(0, 1000)));

//Check if user email exists
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'") or die($mysqli->error());

//Check if any field is empty
if (empty($_POST['first_name'])) {
    $_SESSION['empty_fn'] = "To pole nie może być puste!";
    header("location: ../register_page.php");
} else if (empty($_POST['last_name'])) {
    $_SESSION['empty_ln'] = "To pole nie może być puste!";
    header("location: ../register_page.php");
} else if (empty($_POST['email'])) {
    $_SESSION['empty_email'] = "Musisz podać email!";
    header("location: ../register_page.php");
} else if (empty($_POST['password'])) {
    $_SESSION['empty_password'] = "Musisz podać hasło!";
    header("location: ../register_page.php");
}
//email exists
else if ($result->num_rows > 0) {

    $_SESSION['email_error'] = 'Konto z takim emailem już istnieje!';
    unset($_SESSION['email_temp']);
    header("location: ../register_page.php");
}
//passwords don't match
elseif ($_POST['password'] != $_POST['re_password']) {
    $_SESSION['password_error'] = 'Podane hasła nie zgadzają się!';
    header("location: ../register_page.php");
}
//email doesn't exist
else {
    $sql = "INSERT INTO accounts (first_name, last_name, email, password, role, hash) "
            . "VALUES ('$first_name','$last_name','$email','$password','student','$hash')";

    if ($mysqli->query($sql)) {
        $_SESSION['active'] = 0;
        $_SESSION['logged_in'] = true;

        //Unset temporary variables
        unset($_SESSION['email_temp']);
        unset($_SESSION['first_name_temp']);
        unset($_SESSION['last_name_temp']);

        //Set session variables used in profile.php
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['first_name'] = $_POST['first_name'];
        $_SESSION['last_name'] = $_POST['last_name'];
        $_SESSION['role'] = "student";

        //Email Settings
        $mail->setFrom("webquizphp@gmail.com", "WEBQuiz");
        $mail->addAddress($email);
        $mail->Subject = "Potwierdź swoje konto!";
        $mail->Body = '
        Witaj ' . $first_name . ',
        Dziękujemy za rejestracje na naszej stronie!
        Kliknij na ten link, aby potwierdzić swoje konto:
        http://localhost/WEBQuiz/include/verify.php?email=' . $email . '&hash=' . $hash;
        ;

        if ($mail->send()) {
            $_SESSION['message'] = "Potwierdzenie konta zostało wysłane na email: $email, aktywuj swoje konto"
                    . "naciskając link w wiadomości!";
        } else {
            $_SESSION['message'] = "Coś poszło nie tak: " . $mail->ErrorInfo;
        }

        header("location: ../index.php");
    } else {
        $_SESSION['message'] = 'Rejestracja nie powiodła się!' . $mysqli->error;
        header("location: ../register_page.php");
    }
}