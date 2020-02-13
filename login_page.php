<?php
require 'header.php';
?>
<?php
if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] != false) {
    header("location: index.php");
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Logowanie</h1>
            <form action="include/login.php" method="post">
                <div class="form-item">
                    <label>Email:</label>
                    <input type="text" name="email" placeholder="Podaj swój email..." value="<?php
                    if (isset($_SESSION['email'])) {
                        echo $_SESSION['email'];
                    }
                    ?>">
                    <p class="<?php
                    if (isset($_SESSION['email_error'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                       echo $_SESSION['email_error'];
                       ?></p>
                </div>
                <div class="form-item">
                    <label>Hasło:</label>
                    <input type="password" name="password" placeholder="Podaj swoje hasło...">
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
                <input type="submit" value="Zaloguj się">
                <p>
                    <label>Potrzebujesz konta?</label><a class="active" href="register_page.php">Zarejestruj się</a>
                </p>
            </form>
        </section>
    </div>
</main>

<?php
require 'footer.php';


