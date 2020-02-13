<?php
require 'administration_header.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}
?>

<main>
    <div class="slogan">
        <h1 class="slogan-main">
            ADMINISTRATION PANEL
        </h1>
    </div>
</main>

<?php
require 'footer.php';