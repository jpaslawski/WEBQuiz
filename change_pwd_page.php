<?php
require 'header.php';
require 'include/db.php';
?>

<?php
if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] != true) {
    header("location: index.php");
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Zmiana hasła</h1>
            <form action="include/change_pwd.php" method="post">
                <div class="form-item">
                    <label>Aktualne hasło:</label>
                    <input type="password" name="current_password" placeholder="Wpisz hasło, które teraz używasz...">
                    <p class="<?php
                    if (isset($_SESSION['password_error'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['password_error'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Nowe hasło:</label>
                    <input type="password" name="password" placeholder="Podaj nowe hasło...">
                    <p class="<?php
                    if (isset($_SESSION['new_password_error']) || isset($_SESSION['empty_password'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           if (isset($_SESSION['new_password_error'])) {
                               echo $_SESSION['new_password_error'];
                           } elseif (isset($_SESSION['empty_password'])) {
                               echo $_SESSION['empty_password'];
                           }
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Powtórz nowe hasło:</label>
                    <input type="password" name="re_password" placeholder="Wpisz ponownie nowe hasło...">
                </div>
                <input type="submit" value="Zapisz">
            </form>
        </section>
    </div>
</main>

<?php
require 'footer.php';
