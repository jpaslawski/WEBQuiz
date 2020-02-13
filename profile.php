<?php
include 'header.php';
?>

<?php
if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] != true) {
    header("location: index.php");
}
?>
<main>
    <div class="wrapper-main">
        <section class="transparent">
            <h1>Profil użytkownika</h1>
            <div class="profile-item">
                <p class="profile-label">Imię i nazwisko:</p>
                <p class="user-parameter"><?php
                    echo $_SESSION['first_name'] . " " . $_SESSION['last_name'];
                    ?></p>
            </div>
            <div class="profile-item">
                <p class="profile-label">Email:</p>
                <p class="user-parameter"><?php
                    echo $_SESSION['email'];
                    ?></p>
            </div>
            <div class="profile-item">
                <p class="profile-label">Numer indeksu:</p>
                <p class="user-parameter"><?php
                    if (isset($_SESSION['index']) AND ! ($_SESSION['index'] == 'NULL')) {
                        echo $_SESSION['index'];
                    } else {
                        echo 'Nie został jeszcze ustawiony!';
                    }
                    ?></p>
            </div>
            <a href="update_user_page.php"><input type="submit" value="Aktualizuj konto"></a>
            <p><a href="change_pwd_page.php"><input type="submit" value="Zmień hasło"></a></p>
        </section>
    </div>
</main>

<?php
include 'footer.php';


