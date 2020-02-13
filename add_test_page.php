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
            <h1>Formularz dodawania testu</h1>
            <form action="include/add_test.php" method="post">
                <div class="form-item">
                    <label>Nazwa testu:</label>
                    <input type="text" name="name" placeholder="Tu wpisz nazwę testu...">
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
                    <input type="text" name="info" placeholder="Podaj dodatkowe informacje dotyczące testu...">
                </div>
                <input type="submit" value="Dodaj">
            </form>
            <a href="administration_tests.php" style="margin:0;"><button class="cancel" style="margin:0;" type="submit" name="submit">Wróć</button></a>
        </section>
    </div>
</main>

<?php
require 'footer.php';

