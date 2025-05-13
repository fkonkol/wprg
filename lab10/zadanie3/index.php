<?php

require 'Authenticator.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new Authenticator)->logout();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 3</title>
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 
</head>
<body>
    <?php if (isset($_SESSION['user'])): ?>
        <h2>Witaj, <?= $_SESSION['user']['email'] ?>!</h2>
        <form method="POST">
            <button type="submit">Wyloguj się</button>
        </form>
    <?php else: ?>
        <a href="/login.php">Zaloguj się</a>
    <?php endif; ?>
</body>
</html>
