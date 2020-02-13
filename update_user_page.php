<?php
require 'header.php';
?>

<?php
if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] != true) {
    header("location: index.php");
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Aktualizacja danych użytkonika</h1>
            <form action="include/update_user.php" method="post">
                <div class="form-item">
                    <label>Imię:</label>
                    <input type="text" name="first_name" placeholder="Podaj swoje imię..." value="<?php
                    echo $_SESSION['first_name'];
                    ?>">
                </div>
                <div class="form-item">
                    <label>Nazwisko:</label>
                    <input type="text" name="last_name" placeholder="Podaj swoje nazwisko..." value="<?php
                    echo $_SESSION['last_name'];
                    ?>">
                </div>
                <div class="form-item">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Podaj swój email..." value="<?php
                    echo $_SESSION['email'];
                    ?>" disabled>
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
                    <label>Numer indeksu:</label>
                    <input type="text" name="index" placeholder="Podaj swój numer indeksu..." value="<?php
                    if (isset($_SESSION['index'])) {
                        echo $_SESSION['index'];
                    }
                    ?>">
                    <p class="<?php
                    if (isset($_SESSION['index_error'])) {
                        echo 'error';
                    } else {
                        echo 'none';
                    }
                    ?>"><?php
                           echo $_SESSION['index_error'];
                           ?></p>
                </div>
                <input type="submit" value="Zapisz">
                <p>
            </form>
        </section>
    </div>
</main>

<?php
require 'footer.php';


