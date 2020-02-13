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
            <a href="add_question_page.php">
                <button>Dodaj nowe pytanie</button>
            </a>
        </div>
        <div class="transparent" style="text-align: right;">
            <form action="" method="post" style="padding-right: 50px;">
                Filtruj:
                <select name="category">
                    <option value="Wszystkie">Wszystkie</option>
                    <option value="HTML" <?=(isset($_POST['filter']) AND $_POST['category'] == 'HTML') ? ' selected="selected"' : '';?>>HTML</option>
                    <option value="JS" <?=(isset($_POST['filter']) AND $_POST['category'] == 'JS') ? ' selected="selected"' : '';?>>JS</option>
                    <option value="PHP" <?=(isset($_POST['filter']) AND $_POST['category'] == 'PHP') ? ' selected="selected"' : '';?>>PHP</option>
                    <option value="JAVA" <?=(isset($_POST['filter']) AND $_POST['category'] == 'JAVA') ? ' selected="selected"' : '';?>>JAVA</option>
                    <option value="AJAX" <?=(isset($_POST['filter']) AND $_POST['category'] == 'AJAX') ? ' selected="selected"' : '';?>>AJAX</option>
                    <option value="CSS" <?=(isset($_POST['filter']) AND $_POST['category'] == 'CSS') ? ' selected="selected"' : '';?>>CSS</option>
                    <option value="Inne" <?=(isset($_POST['filter']) AND $_POST['category'] == 'Inne') ? ' selected="selected"' : '';?>>Inne</option>
                </select>
                <input class="btn-submit" type="submit" name="filter" value="Wybierz">
            </form>
            <div class="table-outter">

                <?php
                //Check if filter is enabled
                if (isset($_POST['filter']) AND $mysqli->escape_string($_POST['category']) != "Wszystkie") {
                    $category = $mysqli->escape_string($_POST['category']);
                    $result = $mysqli->query("SELECT * FROM questions WHERE category='" . $category . "'");
                } else {
                    $result = $mysqli->query("SELECT * FROM questions");
                }
                
                //Check if result is not empty
                if (mysqli_num_rows($result) != 0) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Kategoria</th>";
                    echo "<th>Pytanie</th>";
                    echo "<th class='center-content'>Odpowiedź A</th>";
                    echo "<th class='center-content'>Odpowiedź B</th>";
                    echo "<th class='center-content'>Odpowiedź C</th>";
                    echo "<th class='center-content'>Odpowiedź D</th>";
                    echo "<th class='center-content'>Poprawna odpowiedź</th>";
                    echo "<th class='center-content'>Autor</th>";
                    echo "<th class='center-content'>Plik</th>";
                    echo "<th class='center-content'>Działanie</th>";
                    echo "</tr>";
                    
                    //variable for changing row color
                    $i = 0;
                    while ($q = $result->fetch_assoc()) {
                        if ($i%2 == 1) {  
                            echo "<tr class='row1'>";
                        } else {
                            echo "<tr>";
                        }
                        echo "<td class='center-content'>" . $q['category'] . "</th>";
                        echo "<td style='width:40%;word-wrap:break-word;'>" . $q['question'] . "</th>";
                        echo "<td>" . "<textarea readonly='readonly'>" . $q['answerA'] . "</textarea>" . "</td>";
                        echo "<td>" . "<textarea readonly='readonly'>" . $q['answerB'] . "</textarea>" . "</td>";
                        echo "<td>" . "<textarea readonly='readonly'>" . $q['answerC'] . "</textarea>" . "</td>";
                        echo "<td>" . "<textarea readonly='readonly'>" . $q['answerD'] . "</textarea>" . "</td>";
                        echo "<td class='center-content'>" . $q['right_answer'] . "</td>";
                        echo "<td class='center-content'>" . $q['author'] . "</td>";
                        echo "<td class='center-content'>"; 
                        if (!empty($q['file_name'])) {
                            echo "<img src='img/yes.png'>";
                        } else {
                            echo "<img src='img/no.png'>";
                        }
                        echo "</td>";
                        echo "<td class='center-content'><a href='edit_question_page.php?id=" . $q['id'] . "'><button class='action'>EDYTUJ</button></a>"
                        . "<a href='delete_question_page.php?id=" . $q['id'] . "'><button class='action delete'>USUŃ</button></a></td>";
                        echo "</tr>";
                        
                        $i++;
                    }
                    echo "</table>";
                } else {
                    echo "<p style='text-align:center;'>W tej kategorii nie ma żadnych pytań</p>";
                }
                ?>
            </div>
        </div>
</main>
<script>autosize(document.getElementsByTagName("textarea"));</script>
<?php
require 'footer.php';
