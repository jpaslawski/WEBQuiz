<?php
session_start();

include 'include/db.php';
include 'include/replace_function.php';

//Get values from SESSION
$arrayQuestions = $_SESSION['arrayQuestions'];
$questionNumber = $mysqli->escape_string($_SESSION['questionNumber']);

//Get question from database
$question_id = $arrayQuestions[$questionNumber];
$queryQuestion = $mysqli->query("SELECT * FROM questions WHERE id='$question_id'");
$question = $queryQuestion->fetch_assoc();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>Pytanie <?php echo $questionNumber + 1; ?></title>
        <link rel="stylesheet" href="css/styles.css" media="all" type="text/css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
        <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    </head>
    <body>
        <div class="wrapper-main">
            <section class="test">
                <div style="display: flex;">
                    <h1 id="countDown" class="left-content" style="width:50%;margin:10px;font-size: 30px"></h1>
                    <h1 id="qNumber" class="right-content" style="width:50%;font-weight:100;font-size: 20px;"><?php echo "Pytanie: " . ($questionNumber + 1) . " / " . sizeof($arrayQuestions); ?></h1>
                </div>
                <h1 class="test-main center-content"><?php echo $question['question']; ?></h1>

                <?php
                if (!empty($question['file_name'])) {
                    echo "<div class='form-item center-content'>";
                    $fileType = pathinfo($question['file_name'], PATHINFO_EXTENSION);
                    if (strtolower ($fileType) == 'txt') {
                        echo "<textarea class='answer center-content' readonly>";
                        echo file_get_contents("additionalFiles/" . $question['file_name']);
                        echo "</textarea>";
                    } else if (strtolower ($fileType) == 'png' || strtolower ($fileType) == 'jpg') {
                        echo "<img class='question-image' src='additionalFiles/" . $question['file_name'] . "'>";
                    }
                    echo "</div>";
                }
                ?>
                <div class="answer">
                    <label class="answer">
                        <input id="check1" class="answer" type="checkbox" name="A" onclick="selectOnlyThis(this.id)">
                        A:</label>
                    <textarea class="answer" readonly><?php echo $question['answerA']; ?></textarea>

                </div>
                <div class="answer">
                    <label class="answer" >
                        <input id="check2" class="answer" type="checkbox" name="B"  onclick="selectOnlyThis(this.id)">
                        B:</label>
                    <textarea class="answer" readonly><?php echo $question['answerB']; ?></textarea>
                </div>
                <div class="answer">
                    <label class="answer" >
                        <input id="check3" class="answer" type="checkbox" name="C"  onclick="selectOnlyThis(this.id)">
                        C:</label>
                    <textarea class="answer" readonly><?php echo $question['answerC']; ?></textarea>
                </div>
                <div class="answer">
                    <label class="answer" >
                        <input id="check4" class="answer" type="checkbox" name="D"  onclick="selectOnlyThis(this.id)">
                        D:</label>
                    <textarea class="answer" readonly><?php echo $question['answerD']; ?></textarea>
                </div>
                <button id="submitBtn" onclick="nextQuestion()">Następne pytanie</button>
            </section>
        </div>
        <script>autosize(document.getElementsByTagName("textarea"));</script>
    </body>
</html>