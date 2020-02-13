<?php
require 'administration_header.php';
require 'include/db.php';

if ($_SESSION['role'] != "teacher" AND $_SESSION['role'] != "admin") {
    $_SESSION['message'] = "Nie masz uprawnień do korzystania z tej strony!";
    header("location: index.php");
}
?>

<main>
    <div class="container">
        <div class="table-outter">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Email</th>
                    <th>Numer indeksu</th>
                    <th>Uprawnienia</th>
                    <th>Aktywny</th>
                    <th>Działanie</th>
                </tr>
                <?php
                $result = $mysqli->query("SELECT * FROM accounts");

                //variable for changing row color
                $i = 0;
                while ($user = $result->fetch_assoc()) {
                    if ($i % 2 == 1) {
                        echo "<tr class='row1'>";
                    } else {
                        echo "<tr>";
                    }
                    echo "<td>" . $user['id'] . "</th>";
                    echo "<td>" . $user['first_name'] . "</td>";
                    echo "<td>" . $user['last_name'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td class='center-content'>" . $user['index'] . "</td>";
                    echo "<td class='center-content'>" . $user['role'] . "</td>";
                    echo "<td class='last-column center-content'>" . $user['active'] . "</td>";
                    echo "<td class='last-column center-content'>";
                    if ($user['role'] == 'student') {
                        echo "<a href='include/make_teacher.php?id=" . $user['id'] . "'><button class='action'>Mianuj nauczycielem</button></a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                    $i++;
                }
                ?>
            </table>
        </div>
    </div>>
</main>

