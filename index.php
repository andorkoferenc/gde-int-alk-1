<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In.Alk.I. Vizsga</title>
</head>
<body>
    <h1>Internetes Alkalmazásfejlesztés I. - Viszgafeladat </h1>

    <?php if(!isset($_SESSION['username'])): ?>
    <p>Ön nincs bejelentkezve! <br> Kérjük <a href="login.php">jelentkezzen be</a> a további menüpontok eléréséhez.</p>
    <?php endif; ?>

    <?php if(isset($_SESSION['username'])): ?>
        <section>
            <p>
                Bejelentkezett felhasználó: <b><?= $_SESSION['username'] ?></b><br>
                <a href="logout.php">Kijelentezés</a>
            </p>
        </section>
    <?php endif; ?>





    <nav>
        <h2>Menüpontok:</h2>

        <ul>

            <?php if(isset($_SESSION['username'])): ?>
                <li>
                    <a href="posts.php">Bejegyzések listázása</a>
                </li>

                <li>
                    <a href="post_new.php">Új bejegyzés létrhozása</a>
                </li>
                <li>
                    <a href="logout.php">Kijelentezés</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="login.php">Bejelentkezés</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php if(isset($_SESSION['username'])): ?>
        <section>
            <h2>A program készítőjének adatai:</h2>
            <p>
                Hallgató neve: Andorkó Ferenc <br>
                Neptun kód: C55COD <br>
                Intézmény: Gábor Dénes Egyetem <br>
            </p>
        </section>
    <?php endif; ?>

</body>
</html>