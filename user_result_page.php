<?php
require 'header.php';
require 'include/db.php';
?>

<main>
    <?php
    if (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == true) {
        echo "<div class='container'>";
        echo "<div class='table-outter'>";

        //Get user ID
        $email = $_SESSION['email'];
        $queryUser = $mysqli->query("SELECT * FROM accounts WHERE email='$email'");
        $user = $queryUser->fetch_assoc();
        $user_id = $user['id'];

        //Get user results
        $queryDate = $mysqli->query("SELECT * FROM `results` WHERE user='$user_id'");

        if (!mysqli_num_rows($queryDate)) {
            echo "<div class='slogan'>";
            echo "<h1 class='slogan-secondary center-content'>Nie wypełniłeś jeszcze żadnych testów</h1>";
            echo "</div>";
        } else {
            echo "<table>";
            echo "<tr>";
            echo "<th>Nazwa testu</th>";
            echo "<th>Wynik</th>";
            echo "<th class='center-content'>Data wypełnienia</th>";
            echo "</tr>";
            $i = 0;
            while ($result = $queryDate->fetch_assoc()) {
                if ($i % 2 == 1) {
                    echo "<tr class='row1'>";
                } else {
                    echo "<tr>";
                }
                echo "<td class='center-content'>" . $result['test_name'] . "</th>";
                echo "<td class='center-content'>" . $result['percentage'] . "</th>";
                echo "<td>" . $result['date_added'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='slogan'>";
        echo "<h1 class='slogan-secondary center-content'><a style='font-size:30px;color:#0073FF;' href='login_page.php'>Zaloguj się</a>, aby zobaczyć swoje wyniki</h1>";
        echo "</div>";
    }
    ?>

</main>

<?php
require 'footer.php';
