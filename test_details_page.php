<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $test_id = $mysqli->escape_string($_GET['id']);

    $result = $mysqli->query("SELECT * FROM tests WHERE id='$test_id'");
    $t = $result->fetch_assoc();
}
?>

<main>
    <h1 class="test-name"><?php echo $t['name']; ?></h1>
    <div class="container">
        <div class="admin-lower-bar">
            <a href="add_q2t_page.php?test_id=<?php echo $test_id; ?>">
                <button>Dodaj nowe pytanie do tego testu</button>
            </a>
        </div>
        <div class="table-outter">
            <?php
            $counter = 0;
            $queryQuestions = $mysqli->query("SELECT question_id FROM test_question WHERE test_id='$test_id'");

            //Check if result is not empty
            if (mysqli_num_rows($queryQuestions) != 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Pytania</th>";
                echo "<th class='center-content'>Działanie</th>";
                echo "</tr>";

                //Put question IDs in an array
                while ($question = $queryQuestions->fetch_assoc()) {
                    $arrayQuestions[$counter] = $question['question_id'];
                    $counter++;
                }
                for ($i = 0; $i < $counter; $i++) {
                    $result = $mysqli->query("SELECT * FROM questions WHERE id='$arrayQuestions[$i]'");
                    $q = $result->fetch_assoc();

                    if ($i % 2 == 1) {
                        echo "<tr class='row1'>";
                    } else {
                        echo "<tr>";
                    }
                    echo "<td>" . $q['question'] . "</td>";
                    echo "<td class='center-content'><a href='include/delete_q_from_t.php?question_id=" . $q['id'] . "&test_id=" . $test_id . "'><button class='action delete'>USUŃ</button></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align:center;'>W tym teście nie ma żadnych pytań.</p>";
            }
            ?>
        </div>
    </div>
</main>
<?php
require 'footer.php';
