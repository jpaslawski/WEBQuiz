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
            <h1>Formularz edytowania testu</h1>
            <form action="include/edit_test.php?id=<?php echo $id; ?>" method="post">
                <div class="form-item">
                    <label>Nazwa testu:</label>
                    <input type="text" name="name" placeholder="Tu wpisz nazwę testu..." value="<?php
                    echo $t['name'];
                    ?>">
                    <p class="<?php
                    if (isset($_SESSION['empty_name'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['empty_name'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Informacje o teście:</label>
                    <input type="text" name="info" placeholder="Podaj dodatkowe informacje dotyczące testu..." value="<?php
                    echo $t['info'];
                    ?>">
                </div>
                <input type="submit" value="Aktualizuj">
            </form>
            <a href="administration_tests.php" style="margin:0;"><button class="cancel" style="margin:0;" type="submit" name="submit">Wróć</button></a>
        </section>
    </div>
</main>

<?php
require 'footer.php';