<?php
session_start();

include 'include/db.php';

if (isset($_GET['id'])) {
    $test_id = $mysqli->escape_string($_GET['id']);

    //Get all questions in this test
    $counter = 0; 
    $queryQuestionsInTest = $mysqli->query("SELECT * FROM test_question WHERE test_id='$test_id'");

    //Put question IDs in an array
    while ($question = $queryQuestionsInTest->fetch_assoc()) {
        $arrayQuestions[$counter] = $question['question_id'];
        $counter++;
    }
    
    //Put question array in session, create answers array, set question number to 0 and set question amount
    $_SESSION['arrayQuestions'] = $arrayQuestions;
    $_SESSION['questionNumber'] = 0;
    $_SESSION['questionAmount'] = $counter;
    $_SESSION['test_id'] = $test_id;
    
    //Get information about the test
    $testInfo = $mysqli->query("SELECT * FROM tests WHERE id='$test_id'");
    $test = $testInfo->fetch_assoc();
} else {
    $_SESSION['message'] = "Coś poszło nie tak!";
    header("location: user_test_page.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>Pytanie</title>
        <link rel="stylesheet" href="css/styles.css" media="all" type="text/css">
    </head>
    <body>
        <div class="wrapper-main">
            <section class="test">
                <h1 class="left-content">Przystępujesz do testu:</h1>
                <h1 class="test-main center-content"><?php echo $test['name']; ?></h1>
                <h1 class="test-secondary">Będziesz miał jedną minutę, aby odpowiedzieć na każde pytanie.
                    Po tym czasie, jeśli nie zaznaczysz żadnej odpowiedzi, zostaniesz przekierowany do kolejnego
                    pytania. Nie ma możliwości powrotu do wcześniejszego pytania, więc każda odpowiedź jest definitywna.
                    Pytania są jednekrotnego wyboru. Powodzenia!</h1>
                <a href="answer_question_page.php"><button>Rozpocznij wypełnianie</button></a>
            </section>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
    </body>
</html>

