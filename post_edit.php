<?php require_once('login_check.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bejegyzés szerkesztése</title>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        try {
            // Kapcsolódás az adatbázishoz
            $pdo_conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
            // Kivétel kiváltása a hibás lekérdezések esetén
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Ellenőrizzük, hogy az id létezik-e és, hogy a cím mező ki van-e töltve
            if (!empty($_POST['id']) && !empty($_POST['title'])) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $content = $_POST['content'] ?? '';
                $modified_at = date('Y-m-d H:i:s');

                $sql = "UPDATE posts SET title = :title, content = :content, modified_at = :modified_at WHERE id = :id";
                $stmt = $pdo_conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':modified_at', $modified_at);
                $stmt->execute();

                echo '<span class="success">A bejegyzés sikeresen módosítva lett!</span><br>';
                echo '<a href="post.php?id='.$id.'">A bejegyzés megtekintése<a>';

                $sql = "SELECT * FROM posts WHERE id = :id";
                $stmt = $pdo_conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $erros[] = 'Hiba: Hiányzó adatok!';
            }

            $pdo_conn = null;
        } catch (PDOException $e) {
            echo 'Hiba: ' . $e->getMessage();
        }
    } elseif (isset($_GET['id'])) {
        try {
            // Kapcsolódás az adatbázishoz
            $pdo_conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
            // Kivétel kiváltása a hibás lekérdezések esetén
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = $_GET['id'];

            $sql = "SELECT * FROM posts WHERE id = :id";
            $stmt = $pdo_conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $pdo_conn = null;
        } catch (PDOException $e) {
            echo "Hiba: " . $e->getMessage();
        }
    }


    ?>


    <h2>Bejegyzés szerkesztése</h2>

    <?php if(count($errors) > 0): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $k=>$v): ?>
                    <li><?= $v ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="post_edit.php?id=<?= $id ?>">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?? ''; ?>">
        <label for="title">Cím*:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $row['title'] ?? ''; ?>" required><br><br>

        <label for="content">Tartalom:</label><br>
        <textarea id="content" name="content"><?php echo $row['content'] ?? ''; ?></textarea><br><br>

        <input type="submit" name="submit" value="Módosítás">
    </form>
    <p>* A csillagal jelölt mezőket kötelező kitölteni!</p>

</div>
</body>
</html>





