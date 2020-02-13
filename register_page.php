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
            <h1>Formularz rejestracji konta użytkownika</h1>
            <form action="include/register.php" method="post">
                <div class="form-item">
                    <label>Imię:</label>
                    <input type="text" name="first_name" placeholder="Podaj swoje imię..." value="<?php
                    if (isset($_SESSION['first_name_temp'])) {
                        echo $_SESSION['first_name_temp'];
                    }
                    ?>">
                    <p class="<?php
                    if (isset($_SESSION['empty_fn'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['empty_fn'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Nazwisko:</label>
                    <input type="text" name="last_name" placeholder="Podaj swoje nazwisko..." value="<?php
                    if (isset($_SESSION['last_name_temp'])) {
                        echo $_SESSION['last_name_temp'];
                    }
                    ?>">
                    <p class="<?php
                    if (isset($_SESSION['empty_ln'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['empty_ln'];
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Podaj swój email..." value="<?php
                    if (isset($_SESSION['email_temp'])) {
                        echo $_SESSION['email_temp'];
                    }
                    ?>">
                    <p class="<?php
                    if (isset($_SESSION['email_error']) || isset($_SESSION['empty_email'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           if (isset($_SESSION['email_error'])) {
                               echo $_SESSION['email_error'];
                           } elseif (isset($_SESSION['empty_email'])) {
                               echo $_SESSION['empty_email'];
                           }
                           ?></p>
                </div>
                <div class="form-item">
                    <label>Hasło:</label>
                    <input type="password" name="password" placeholder="Podaj hasło...">
                    <p class="<?php
                           if (isset($_SESSION['password_error']) || isset($_SESSION['empty_password'])) {
                               echo 'error';
                           } else {
                               echo 'none';
                           }
                           ?>"><?php
                            if (isset($_SESSION['password_error'])) {
                               echo $_SESSION['password_error'];
                           } elseif (isset($_SESSION['empty_password'])) {
                               echo $_SESSION['empty_password'];
                           }
                       ?></p>
                </div>
                <div class="form-item">
                    <label>Powtórz hasło:</label>
                    <input type="password" name="re_password" placeholder="Podaj hasło ponownie...">
                </div>
                <input type="submit" value="Zarejestruj się">
                <p>
                    <label>Posiadasz już konto?</label><a class="active" href="include/login_page.php">Zaloguj się</a>
                </p>
            </form>
        </section>
    </div>
</main>

<?php
require 'footer.php';
