<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}
?>

<main>

    <div class="container">
        <div class="admin-lower-bar">
            <a href="add_test_page.php">
                <button>Dodaj nowy test</button>
            </a>
        </div>
        <div class="table-outter">
            <?php
            $result = $mysqli->query("SELECT * FROM tests");
            //Check if result is not empty
            if (mysqli_num_rows($result) != 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th>Nazwa</th>";
                echo "<th>Informacje</th>";
                echo "<th class='center-content'>Ilość pytań</th>";
                echo "<th class='center-content'>Działanie</th>";
                echo "</tr>";

                //variable for changing row color
                $i = 0;
                while ($t = $result->fetch_assoc()) {
                    if ($i % 2 == 1) {
                        echo "<tr class='row1'>";
                    } else {
                        echo "<tr>";
                    }
                    echo "<td>" . $t['name'] . "</td>";
                    echo "<td style='width:40%;word-wrap:break-word;'>" . $t['info'] . "</td>";

                    //Counting the amount of questions in a test
                    $counter = 0;
                    $test_id = $t['id'];
                    $queryQuestionsInTest = $mysqli->query("SELECT * FROM test_question WHERE test_id='$test_id'");
                    while ($queryQuestionsInTest->fetch_assoc()) {
                        $counter++;
                    }
                    echo "<td class='center-content'>" . $counter . " </td>";
                    echo "<td class='center-content'><a href='edit_test_page.php?id=" . $t['id'] . "'><button class='action'>EDYTUJ</button></a>"
                    . "<a href='delete_test_page.php?id=" . $t['id'] . "'><button class='action delete'>USUŃ</button></a>"
                    . "<a href='test_details_page.php?id=" . $t['id'] . "'><button class='action cancel'>PYTANIA</button></a></td>";
                    echo "</tr>";
                    $i++;
                }
                echo "</table>";
            } else {
                echo "<p style='text-align:center;'>Nie ma żadnych testów w bazie danych.</p>";
            }
            ?>
        </div>
    </div>
</main>
<?php
require 'footer.php';
