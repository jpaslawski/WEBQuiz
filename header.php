<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>WEB Quiz</title>
        <link rel="stylesheet" href="css/styles.css" media="all" type="text/css">
    </head>
    <body>
        <header class="transparent">
            <a href="index.php"><img class="logo" src="img/logo.png" alt="logo"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Strona główna</a></li>
                    <li><a href="user_test_page.php">Testy</a></li>
                    <li><a href="user_result_page.php">Wyniki</a></li>
                </ul>
            </nav>
            <div class="right-nav">
                <a class=" <?php
                if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
                    echo 'none';
                }
                ?>" href="profile.php">Profil</a>
                <a href="login_page.php"><button class="
                    <?php
                    if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true) {
                        echo 'none';
                    }
                    ?>">Zaloguj się</button></a>
                <a href="register_page.php"><button class="
                    <?php
                    if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true) {
                        echo 'none';
                    }
                    ?>">Rejestracja</button></a>
                <a href="logout.php"><button class="
                    <?php
                    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
                        echo 'none';
                    }
                    ?>">Wyloguj się</button></a>
            </div>
        </header>
        <div id="message_bar" class="<?php
             if (isset($_SESSION['message'])) {
                 echo 'message-bar';
             } else {
                 echo 'none';
             }
             ?>"><?php echo $_SESSION['message']; ?>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
        <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<script type='text/javascript'> " .
            "$('#message_bar').fadeIn('fast', function () {" .
            "$('#message_bar').fadeOut(4000);});</script>';";
        }
        ?>
    </body>
</html>

