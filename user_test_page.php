<?php
require 'header.php';
require 'include/db.php';

if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] != true) {
    header("location: index.php");
}

//Retrieving all tests from database
$queryTests = $mysqli->query("SELECT * FROM tests");
?>
<main>
    <?php
    //Check if there are any tests to display
    if ($queryTests) {
        while ($test = $queryTests->fetch_assoc()) {
            echo "<div class='wrapper-main'>";
            echo "<section class='test'>";
            echo "<h1 class='test-main left-content'>" . $test['name'] . "</h1>";
            
            //Counting the amount of questions in a test
            $counter = 0;
            $test_id = $test['id'];
            $queryQuestionsInTest = $mysqli->query("SELECT * FROM test_question WHERE test_id='$test_id'");
            while ($queryQuestionsInTest->fetch_assoc()) {
                $counter++;
            }
            
            echo "<h1 class='test-count right-content'>Ilość pytań: " . $counter . "</h1>";
            echo "<h1 class='test-secondary'>" . $test['info'] . "</h1>";
            echo "<a href='start_test_page.php?id=" . $test['id'] . "'><button>Rozpocznij Test</button></a>";
            echo "</section>";
            echo "</div>";
        }
    } else {
        echo "<div class='wrapper-main'>";
        echo "<section class='transparent'>";
        echo "<h1>Nie ma żadnych testów, które mógłbyś wypełnić.</h1>";
        echo "</section>";
        echo "</div>";
    }
    ?>
</main>

<?php
require 'footer.php';
