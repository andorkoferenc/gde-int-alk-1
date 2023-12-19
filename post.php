<?php require_once('login_check.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bejegyzés</title>
</head>
<body>
<nav>
    <ul>
        <li>
            <a href="index.php">Vissza a kezdőlapra</a>
        </li>
        <li>
            <a href="posts.php">Vissza a bejegyzésekhez</a>
        </li>
        <li>
            <a href="logout.php">Kijelentezés</a>
        </li>
    </ul>
</nav>

<div>
    <?php
    require_once('config.php');

    try {
        // Kapcsolódás az adatbázishoz PDO segítségével
        $pdo_conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
        // Kivétel kiváltása a hibás lekérdezések esetén
        $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ellenőrizzük, van-e a $_GET-ben id paraméter
        if (isset($_GET['id'])) {
            $sql = "SELECT * FROM posts WHERE id = :id";
            $stmt = $pdo_conn->prepare($sql);
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();

            // Ellenőrizzük, hogy van-e eredmény
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<h1>' . $row["title"] . '</h1>';
                echo '<p>';
                echo '<a href="post_edit.php?id='.$_GET['id'].'">A bejegyzés szerkesztése</a><br>';
                echo '<u>Létrehozva:</u> ' . $row["created_at"] . '<br>';
                echo '<u>Módosítva:</u> ' . $row["modified_at"] . '<br>';
                echo '</p>';
                echo '<p><u>Tartalom:</u><br><br>' . $row["content"] . '</p>';
                echo '<a href="post_edit.php?id='.$_GET['id'].'">';
            } else {
                echo 'Nincs ilyen azonosítójú bejegyzés.';
            }
        } else {
            echo 'Nincs megadva azonosító.';
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





