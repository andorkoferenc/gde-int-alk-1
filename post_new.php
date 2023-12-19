<?php require_once('login_check.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Új bejegyzés</title>
    <style>
        .error {
            color: red;
        }
        .success {
            color: green;
            font-weight: bold;
        }
    </style>
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
    $errors = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Kapcsolódás az adatbázishoz
            $pdo_conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
            // Kivétel kiváltása a hibás lekérdezések esetén
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Ellenőrizzük, hogy a title mező ki van-e töltve
            if (!empty($_POST['title'])) {
                $title = $_POST['title'];
                $content = $_POST['content'] ?? '';

                $sql = "INSERT INTO posts (title, content) VALUES (:title, :content)";
                $stmt = $pdo_conn->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':content', $content);
                $stmt->execute();

                echo '<span class="success">Sikeresen rögzítette a bejegyzést!</span><br>';
                echo '<a href="posts.php">A bejegyzések megtekintése.<a>';

            } else {
                $errors[] = 'A cím mezőt kötelező kitölteni!';
            }

            // Kapcsolat bezárása
            $pdo_conn = null;
        } catch (PDOException $e) {
            echo 'Hiba: ' . $e->getMessage();
        }
    }


    ?>

    <h2>Új bejegyzés rögzítése</h2>
    <?php if(count($errors) > 0): ?>
        <div class="error">
            <ul>
            <?php foreach ($errors as $k=>$v): ?>
                <li><?= $v ?></li>
            <?php endforeach; ?>
            </ul>
        </div>

    <?php endif; ?>
    <form method="post" action="post_new.php">
        <label for="title">Cím*:</label><br>
        <input type="text" id="title" name="title" ><br><br>

        <label for="content">Tartalom:</label><br>
        <textarea id="content" name="content"></textarea><br><br>

        <input type="submit" value="Bejegyzés rögzítése">
    </form>
    <p>* A csillagal jelölt mezőket kötelező kitölteni!</p>

</div>
</body>
</html>





