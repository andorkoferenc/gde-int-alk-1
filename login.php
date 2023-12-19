<?php
session_start();

// Helhazsnálók belépési adatai
$users = array(
    'aaa' => 'aaa',
    'andorkoferenc' => 'c55cod'
);



// Megvizsgáljuk, hogy felhasználó be van-e jelentkezve
if(isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Megvizsgáljuk, hogy az ürlepot elküldték-e?
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ellenőrizzük, hogy a felhasználó létezik-e a users tömbben
    if (array_key_exists($username, $users) && $users[$username] === $password) {
        // Sikeres bejelentkezés
        // Létrehozunk egy session változót
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        // Sikertelen bejelentkezés
        // Hibaüzenet
        $error = "Hibás felhasználónév vagy jelszó!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Bejelentkezés</h1>
    <section>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <!-- Bejelentkezési űrlap -->
        <form action="login.php" method="post">

            <label for="username">Felhasználónév:</label>
            <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? null ?>"><br>

            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password"><br>

            <input type="submit" value="Bejelentkezés">
        </form>
    </section>
</body>
</html>