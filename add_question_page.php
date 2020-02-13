<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Formularz dodawania pytania</h1>
            <form action="include/add_question.php" method="post" enctype="multipart/form-data">
                <div class="form-item">
                    <label>Kategoria:</label>
                    <select name="category">
                        <option value="HTML" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'HTML') ? ' selected="selected"' : ''; ?>>HTML</option>
                        <option value="JS" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'JS') ? ' selected="selected"' : ''; ?>>JS</option>
                        <option value="PHP" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'PHP') ? ' selected="selected"' : ''; ?>>PHP</option>
                        <option value="JAVA" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'JAVA') ? ' selected="selected"' : ''; ?>>JAVA</option>
                        <option value="AJAX" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'AJAX') ? ' selected="selected"' : ''; ?>>AJAX</option>
                        <option value="CSS" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'CSS') ? ' selected="selected"' : ''; ?>>CSS</option>
                        <option value="Inne" <?= (isset($_SESSION['category_temp']) AND $_SESSION['category_temp'] == 'Inne') ? ' selected="selected"' : ''; ?>>Inne</option>
                    </select>
                </div>
                <div class="form-item">
                    <label>Treść pytania:</label>
                    <textarea class="textarea-edit" name="question" placeholder="Tu wpisz treść pytania..."><?php
                        if (isset($_SESSION['question_temp'])) {
                            echo $_SESSION['question_temp'];
                        }
                        ?></textarea>
                    <p class="<?php
                    if (isset($_SESSION['empty_question'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['empty_question'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Plik:</label>
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
                    <textarea class="textarea-edit" name="answerA" placeholder="Pierwsza odpowiedź"><?php
                        if (isset($_SESSION['answerA_temp'])) {
                            echo $_SESSION['answerA_temp'];
                        }
                        ?></textarea> 
                    <p class="<?php
                    if (isset($_SESSION['empty_A'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['empty_A'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Odpowiedź B:</label>
                    <textarea class="textarea-edit" name="answerB" placeholder="Druga odpowiedź"><?php
                        if (isset($_SESSION['answerB_temp'])) {
                            echo $_SESSION['answerB_temp'];
                        }
                        ?></textarea>
                    <p class="<?php
                    if (isset($_SESSION['empty_B'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                        echo $_SESSION['empty_B'];
                        ?></p>
                </div>
                <div class="form-item">
                    <label>Odpowiedź C:</label>
                    <textarea class="textarea-edit" name="answerC" placeholder="Trzecia odpowiedź"><?php
                        if (isset($_SESSION['answerC_temp'])) {
                            echo $_SESSION['answerC_temp'];
                        }
                        ?></textarea>
                    <p class="<?php
                    if (isset($_SESSION['empty_C'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                        echo $_SESSION['empty_C'];
                    ?></p>
                </div>
                <div class="form-item">
                    <label>Odpowiedź D:</label>
                    <textarea class="textarea-edit" name="answerD" placeholder="Czwarta odpowiedź"><?php
                        if (isset($_SESSION['answerD_temp'])) {
                            echo $_SESSION['answerD_temp'];
                        }
                        ?></textarea>
                    <p class="<?php
                    if (isset($_SESSION['empty_D'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                    echo $_SESSION['empty_D'];
                    ?></p>
                </div>
                <div class="form-item">
                    <label>Poprawna odpowiedź:</label>
                    <select name="right_answer">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <input type="submit" name="submit" value="Dodaj">
            </form>
            <a href="administration_questions.php" style="margin:0;"><button class="cancel" style="margin:0;" type="submit" name="submit">Wróć</button></a>
        </section>
    </div>
</main>
<script>autosize(document.getElementsByTagName("textarea"));</script>

<?php
require 'footer.php';

