<?php require_once('login_check.php') ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejegyzések</title>
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="index.php">Vissza a kezdőlapra...</a><br>
            </li>
            <li>
                <a href="logout.php">Kijelentezés</a>
            </li>
        </ul>
    </nav>
    <h1>Bejegyzések</h1>
    <a href="post_new.php">Új bejegyzés létrhozása</a><br>

    <div>
        <?php
        require_once('config.php');

        try {
            // Kapcsolódás az adatbázishoz
            $pdo_conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
            // Kivétel kiváltása a hibás lekérdezések esetén
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Lekérdezzük az összes bejegyzést
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $stmt = $pdo_conn->query($sql);

            if ($stmt->rowCount() > 0) {
                echo '<br>';
                echo '<table border="1">';

                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Cím</th>';
                echo '<th>Létrehozva</th>';
                echo '<th>Módosítva</th>';
                echo '<th>Szerkesztés</th>';
                echo '<tr>';

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . "</td>";
                    echo '<td><a href="post.php?id='.$row["id"].'">' . $row["title"] . '<a></td>';
                    echo '<td>' . $row["created_at"] . '</td>';
                    echo '<td>' . $row["modified_at"] . '</td>';
                    echo '<td><a href="post_edit.php?id='.$row["id"].'">szerkesztés<a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'Nincs bejegyzés az adatbázisban.<br><br>';
                echo '<a href="post_new.php">Új bejegyzés létrhozása</a>';
            }

            // Kapcsolat bezárása
            $pdo_conn = null;

        } catch (PDOException $e) {
            echo 'Hiba: ' . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>

