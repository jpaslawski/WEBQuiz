<?php
session_start();
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
                <h1 class="test-main center-content">Test zakończony!</h1>
                <p class="test-secondary">Twój wynik: <?php echo $_SESSION['points'] . " / " . $_SESSION['questionAmount'];?></p>
                <?php 
                if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in']) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Numer pytania</th>";
                    echo "<th>Twoja odpowiedź</th>";
                    echo "<th>Poprawna odpowiedź</th>";
                    echo "</tr>";
                    
                    $arrayAnswers = $_SESSION['arrayAnswers'];
                    $rightAnswers = $_SESSION['rightAnswers'];
                    
                    for($i = 0; $i < $_SESSION['questionAmount']; $i++) {
                        echo "<tr>";
                        echo "<td class='center-content'>" . ($i + 1) . "</td>";
                        echo "<td class='center-content'>" . $arrayAnswers[$i] . "</td>";
                        echo "<td class='center-content'>" . strtoupper($rightAnswers[$i]) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<br>";
                }
                ?>
                
                <a href="index.php"><button>Strona główna</button></a>
            </section>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
    </body>
</html>

<?php

//Unset all SESSION variables for this test
unset($_SESSION['arrayQuestions']);
unset($_SESSION['arrayAnswers']);
unset($_SESSION['questionNumber']);
unset($_SESSION['test_id']);
unset($_SESSION['points']);