<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}

$test_id = $_GET['test_id'];
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Formularz dodawania pytania do testu</h1>
            <div class="form-item">
                <label>Kategoria:</label>
                <form action="" method="post">
                    <select name="category">
                        <option value="HTML" <?=(isset($_POST['submit']) AND $_POST['category'] == 'HTML') ? ' selected="selected"' : '';?>>HTML</option>
                        <option value="JS" <?=(isset($_POST['submit']) AND $_POST['category'] == 'JS') ? ' selected="selected"' : '';?>>JS</option>
                        <option value="PHP" <?=(isset($_POST['submit']) AND $_POST['category'] == 'PHP') ? ' selected="selected"' : '';?>>PHP</option>
                        <option value="JAVA" <?=(isset($_POST['submit']) AND $_POST['category'] == 'JAVA') ? ' selected="selected"' : '';?>>JAVA</option>
                        <option value="AJAX" <?=(isset($_POST['submit']) AND $_POST['category'] == 'AJAX') ? ' selected="selected"' : '';?>>AJAX</option>
                        <option value="CSS" <?=(isset($_POST['submit']) AND $_POST['category'] == 'CSS') ? ' selected="selected"' : '';?>>CSS</option>
                        <option value="Inne" <?=(isset($_POST['submit']) AND $_POST['category'] == 'Inne') ? ' selected="selected"' : '';?>>Inne</option>
                    </select>
                    <input type="submit" name="submit" value="Wybierz">
                </form>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                unset($qFromTest);
                unset($allQuestions);
                //Retrieve questions of given category
                $counter1 = 0;
                $category = $mysqli->escape_string($_POST['category']);
                $queryQuestions = $mysqli->query("SELECT * FROM questions WHERE category='$category'");
                //Put question IDs in an array
                while ($question1 = $queryQuestions->fetch_assoc()) {
                    $allQuestions[$counter1] = $question1['id'];
                    $counter1++;
                }

                if ($counter1 != 0) {

                    //Retrieve questions in this test
                    $counter2 = 0;
                    $questionsInTest = $mysqli->query("SELECT * FROM test_question WHERE test_id='$test_id'");

                    //Put question IDs in an array
                    while ($question2 = $questionsInTest->fetch_assoc()) {
                        $qFromTest[$counter2] = $question2['question_id'];
                        $counter2++;
                    }
                    if (!empty($qFromTest)) {
                        //Difference between arrays - all questions of given category that are not in the 
                        $resultArray = array_diff($allQuestions, $qFromTest);

                        //Re-index array starting from 0
                        $array = array_values($resultArray);
                    } else {
                        $array = array_values($allQuestions);
                    }

                    if (!empty($array)) {
                        echo "<form action='include/add_q2t.php?test_id=" . $test_id . "' method='post'>";
                        echo "<div class='form-item'>";
                        echo "<label>Wybierz pytanie:</label>";
                        echo "<select style='width:90%;word-wrap:break-word;' name='question'>";
                        //Print options to HTML
                        for ($i = 0; $i < sizeof($array); $i++) {
                            $result = $mysqli->query("SELECT * FROM questions WHERE id='$array[$i]'");
                            $q = $result->fetch_assoc();
                            echo "<option value='" . $q['id'] . "'>" . $q['question'] . "</option>";
                        }

                        echo "</select>";
                        echo "</div>";
                        echo "<input type='submit' value='Dodaj'>";
                        echo "</form>";
                    } else {
                        echo "<p>W tej kategorii nie ma pytań możliwych do dodania</p>";
                    }
                } else {
                    echo "<p>W tej kategorii nie ma pytań możliwych do dodania</p>";
                }
            }
            ?>
            <a href="test_details_page.php?id=<?php echo $test_id; ?>" style="margin:0;"><button class="cancel" style="margin:0;" type="submit" name="submit">Wróć</button></a>
        </section>
    </div>
</main>

<?php
require 'footer.php';