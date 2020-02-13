<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>WEB Quiz - Administracja</title>
        <link rel="stylesheet" href="css/styles.css" media="all" type="text/css">
    </head>
    <body>
        <header class="transparent">
            <a href="administration_panel.php"><img class="logo" src="img/logo.png" alt="logo"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="administration_accounts.php">Konta użytkowników</a></li>
                    <li><a href="administration_questions.php">Pytania</a></li>
                    <li><a href="administration_tests.php">Testy</a></li>
                </ul>
            </nav>
            <div class="right-nav">
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
    "$('#message_bar').fadeOut(4000);});</script>";
    }
    ?>
    </body>
</html>