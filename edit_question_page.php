<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $mysqli->escape_string($_GET['id']);

    $result = $mysqli->query("SELECT * FROM questions WHERE id='$id'");
    $q = $result->fetch_assoc();
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Formularz edycji pytania</h1>
            <form action="include/edit_question.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <div class="form-item">
                    <label>Kategoria:</label>
                    <select name="category">
                        <option value="HTML" <?=$q['category'] == 'HTML' ? ' selected="selected"' : '';?>>HTML</option>
                        <option value="JS" <?=$q['category'] == 'JS' ? ' selected="selected"' : '';?> >JS</option>
                        <option value="PHP" <?=$q['category'] == 'PHP' ? ' selected="selected"' : '';?> >PHP</option>
                        <option value="JAVA" <?=$q['category'] == 'JAVA' ? ' selected="selected"' : '';?> >JAVA</option>
                        <option value="AJAX" <?=$q['category'] == 'AJAX' ? ' selected="selected"' : '';?> >AJAX</option>
                        <option value="CSS" <?=$q['category'] == 'CSS' ? ' selected="selected"' : '';?> >CSS</option>
                        <option value="Inne" <?=$q['category'] == 'Inne' ? ' selected="selected"' : '';?> >Inne</option>
                    </select>
                </div>
                <div class="form-item">
                    <label>Treść pytania:</label>
                    <textarea class="textarea-edit" name="question" placeholder="Tu wpisz treść pytania..."><?php echo $q['question']; ?></textarea> 
                </div>
                <div class="form-item">
                    <label><?php if (!empty($q['file_name'])) { echo "Aktualny plik:"; } else { echo "Plik:";}?></label>
                    <p class="center-content">
                <?php
                if (!empty($q['file_name'])) {
                    $fileType = pathinfo($q['file_name'], PATHINFO_EXTENSION);
                    if (strtolower ($fileType) == 'txt') {
                        echo "<textarea class='answer center-content' readonly>";
                        echo file_get_contents("additionalFiles/" . $q['file_name']);
                        echo "</textarea>";
                    } else if (strtolower ($fileType) == 'png' || strtolower ($fileType) == 'jpg') {
                        echo "<img class='question-image' src='additionalFiles/" . $q['file_name'] . "'>";
                    }
                }
                ?></p>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <p class="<?php
                    if (isset($_SESSION['file_error'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['file_error'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Odpowiedź A:</label>
                    <textarea class="textarea-edit" name="answerA" placeholder="Pierwsza odpowiedź"><?php echo $q['answerA']; ?></textarea> 
                </div>
                <div class="form-item">
                    <label>Odpowiedź B:</label>
                    <textarea class="textarea-edit" name="answerB" placeholder="Druga odpowiedź"><?php echo $q['answerB']; ?></textarea> 
                </div>
                <div class="form-item">
                    <label>Odpowiedź C:</label>
                    <textarea class="textarea-edit" name="answerC" placeholder="Trzecia odpowiedź"><?php echo $q['answerC']; ?></textarea> 
                </div>
                <div class="form-item">
                    <label>Odpowiedź D:</label>
                    <textarea class="textarea-edit" name="answerD" placeholder="Czwarta odpowiedź"><?php echo $q['answerD']; ?></textarea>
                </div>
                <div class="form-item">
                    <label>Poprawna odpowiedź:</label>
                    <select name="right_answer">
                        <option value="A" <?=$q['right_answer'] == 'A' ? ' selected="selected"' : '';?>>A</option>
                        <option value="B" <?=$q['right_answer'] == 'B' ? ' selected="selected"' : '';?>>B</option>
                        <option value="C" <?=$q['right_answer'] == 'C' ? ' selected="selected"' : '';?>>C</option>
                        <option value="D" <?=$q['right_answer'] == 'D' ? ' selected="selected"' : '';?>>D</option>
                    </select>
                </div>
                <input type="submit" name="submit" value="Aktualizuj">
            </form>
            <a href="administration_questions.php" style="margin:0;"><button class="cancel" style="margin:0;" type="submit" name="submit">Wróć</button></a>
        </section>
    </div>
</main>
<script>autosize(document.getElementsByTagName("textarea"));</script>

<?php
require 'footer.php';
