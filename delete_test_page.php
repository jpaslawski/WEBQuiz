<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $mysqli->escape_string($_GET['id']);
    
    $result = $mysqli->query("SELECT * FROM tests WHERE id='$id'");
    $t = $result->fetch_assoc();
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Usuwanie pytania z bazy</h1>
            <form action="include/delete_test.php?id=<?php echo $id;?>" method="post">
                <div class="form-item">
                    <label>Czy na pewno chcesz usunąć ten test z bazy danych:</label>
                    <p class="user-parameter"><?php
                    echo $t['name'];?></p>
                </div>
                <button class="delete" type="submit">Usuń</button>
            </form>
            <a style="margin:0;" href="administration_questions.php"><button class="cancel" type="submit">Wróć</button></a>
        </section>
    </div>
</main>

<?php
require 'footer.php';