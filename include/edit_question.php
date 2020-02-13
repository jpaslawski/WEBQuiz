<?php

session_start();
require 'db.php';

//Editing question
//File upload path
$targetDirectory = $_SERVER['DOCUMENT_ROOT'] . "/WEBQuiz/additionalFiles/";
$fileName = explode(".", $_FILES['fileToUpload']['name']);
$newFileName = round(microtime(true)) . "." . end($fileName);
$targetFilePath = $targetDirectory . $newFileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

//Protection against SQL injections
$id = $mysqli->escape_string($_GET['id']);
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
        header("location: ../edit_question_page.php?id=" . $id);
    }
}
//Check if empty
else if (empty($_POST['question'])) {
    $_SESSION['empty_question'] = "To pole nie może być puste!";
    header("location: ../edit_question_page.php?id=" . $id);
} else if (empty($_POST['answerA'])) {
    $_SESSION['empty_A'] = "To pole nie może być puste!";
    header("location: ../edit_question_page.php?id=" . $id);
} else if (empty($_POST['answerB'])) {
    $_SESSION['empty_B'] = "To pole nie może być puste!";
    header("location: ../edit_question_page.php?id=" . $id);
} else if (empty($_POST['answerC'])) {
    $_SESSION['empty_C'] = "To pole nie może być puste!";
    header("location: ../edit_question_page.php?id=" . $id);
} else if (empty($_POST['answerD'])) {
    $_SESSION['empty_D'] = "To pole nie może być puste!";
    header("location: ../edit_question_page.php?id=" . $id);
}

//Get question
$queryQuestion = $mysqli->query("SELECT * FROM `questions` WHERE `id`='$id'") or die($mysqli->error());
$q = $queryQuestion->fetch_assoc();

if (!empty($q['file_name'])) {
    unlink("../additionalFiles/" . $q['file_name']);
}

if (!empty($_FILES['fileToUpload']['name']) AND move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
    $sql = "UPDATE questions SET `question`='$question', `answerA`='$answerA', `answerB`='$answerB', `answerC`='$answerC'"
            . ", `answerD`='$answerD', `right_answer`='$right_answer', `category`='$category', `file_name`='$newFileName' WHERE `id`='$id'";
} else if (empty($_FILES['fileToUpload']['name'])) {
    $sql = "UPDATE questions SET `question`='$question', `answerA`='$answerA', `answerB`='$answerB', `answerC`='$answerC'"
            . ", `answerD`='$answerD', `right_answer`='$right_answer', `category`='$category', `file_name`=NULL WHERE `id`='$id'";
} else {
    $_SESSION['message'] = "Nie udało się poprawnie zapisać pliku! ";
    header("location: ../edit_question_page.php?id=" . $id);
}

if ($mysqli->query($sql)) {
    //Unset temporary variables
    unset($_SESSION['category_temp']);
    unset($_SESSION['question_temp']);
    unset($_SESSION['answerA_temp']);
    unset($_SESSION['answerB_temp']);
    unset($_SESSION['answerC_temp']);
    unset($_SESSION['answerD_temp']);

    $_SESSION['message'] = "Pytanie zostało zaktualizowane!";
    header("location: ../administration_questions.php");
} else {
    $_SESSION['message'] = "Wystąpił problem z zapytaniem do bazy danych! ";
    header("location: ../edit_question_page.php?id=" . $id);
}


