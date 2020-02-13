<?php

session_start();
require 'db.php';

//Adding a new question
//File upload path
if (!empty($_FILES['fileToUpload']['name'])) {
    $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . "/WEBQuiz/additionalFiles/";
    $fileName = explode(".", $_FILES['fileToUpload']['name']);
    $newFileName = round(microtime(true)) . "." . end($fileName);
    $targetFilePath = $targetDirectory . $newFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
}

//Set temporary variables
$_SESSION['category_temp'] = $_POST['category'];
$_SESSION['question_temp'] = $_POST['question'];
$_SESSION['answerA_temp'] = $_POST['answerA'];
$_SESSION['answerB_temp'] = $_POST['answerB'];
$_SESSION['answerC_temp'] = $_POST['answerC'];
$_SESSION['answerD_temp'] = $_POST['answerD'];

//Protection against SQL injections
$category = $mysqli->escape_string($_POST['category']);
$question = $mysqli->escape_string($_POST['question']);
$answerA = $mysqli->escape_string($_POST['answerA']);
$answerB = $mysqli->escape_string($_POST['answerB']);
$answerC = $mysqli->escape_string($_POST['answerC']);
$answerD = $mysqli->escape_string($_POST['answerD']);
$right_answer = $mysqli->escape_string($_POST['right_answer']);

//Find user that is adding the question
$email = $_SESSION['email'];
$result = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
$user = $result->fetch_assoc();

//Set author
$author = $user['id'];

//Check if user have permission (teacher or admin)
if ($user['role'] != "admin" AND $user['role'] != "teacher") {
//Unset temporary variables
    unset($_SESSION['category_temp']);
    unset($_SESSION['question_temp']);
    unset($_SESSION['answerA_temp']);
    unset($_SESSION['answerB_temp']);
    unset($_SESSION['answerC_temp']);
    unset($_SESSION['answerD_temp']);
    $_SESSION['message'] = "Nie masz uprawnień do dodawania pytań!";
    header("location: ../index.php");
}
//Check file
else if (isset($_POST['submit']) AND ! empty($_FILES['fileToUpload']['name'])) {
    $allowedTypes = array('jpg', 'png', 'txt');
    if (!in_array(strtolower($fileType), $allowedTypes)) {
        $_SESSION['file_error'] = "Plik o formacie $fileType nie może być załączony do pytania!";
        header("location: ../add_question_page.php");
    }
}
//Check if empty
else if (empty($_POST['question'])) {
    $_SESSION['empty_question'] = "To pole nie może być puste!";
    header("location: ../add_question_page.php");
} else if (empty($_POST['answerA'])) {
    $_SESSION['empty_A'] = "To pole nie może być puste!";
    header("location: ../add_question_page.php");
} else if (empty($_POST['answerB'])) {
    $_SESSION['empty_B'] = "To pole nie może być puste!";
    header("location: ../add_question_page.php");
} else if (empty($_POST['answerC'])) {
    $_SESSION['empty_C'] = "To pole nie może być puste!";
    header("location: ../add_question_page.php");
} else if (empty($_POST['answerD'])) {
    $_SESSION['empty_D'] = "To pole nie może być puste!";
    header("location: ../add_question_page.php");
}

if (!empty($_FILES['fileToUpload']['name']) AND move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
    $sql = "INSERT INTO questions (question, answerA, answerB, answerC, answerD, right_answer, author, category, file_name) "
            . "VALUES ('$question','$answerA','$answerB','$answerC','$answerD','$right_answer','$author','$category','$newFileName')";
} else if (empty($_FILES['fileToUpload']['name'])) {
    $sql = "INSERT INTO questions (question, answerA, answerB, answerC, answerD, right_answer, author, category) "
            . "VALUES ('$question','$answerA','$answerB','$answerC','$answerD','$right_answer','$author','$category')";
} else {
    $_SESSION['message'] = "Nie udało się poprawnie zapisać pliku! ";
    header("location: ../add_question_page.php");
}

if ($mysqli->query($sql)) {

    //Unset temporary variables
    unset($_SESSION['category_temp']);
    unset($_SESSION['question_temp']);
    unset($_SESSION['answerA_temp']);
    unset($_SESSION['answerB_temp']);
    unset($_SESSION['answerC_temp']);
    unset($_SESSION['answerD_temp']);

    $_SESSION['message'] = "Twoje pytanie zostało dodane poprawnie!";
    header("location: ../administration_questions.php");
} else {
    $_SESSION['message'] = "Upload do bazy nie udał się!";
    header("location: ../administration_questions.php");
}
?>