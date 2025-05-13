<?php

require 'Validator.php';
require 'Authenticator.php';

session_start();

if (isset($_SESSION['user'])) {
    header('location: /');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];

    $errors = [];

    if (!(Validator::email($user['email']) || Validator::password($user['password']))) {
        $errors['_flash'] = 'Niepoprawny email lub hasło.';
    }

    if (count($errors) === 0) {
        if ((new Authenticator)->attempt($user['email'], $user['password'])) {
            header('location: /');
            exit;
        } else {
            $errors['_flash'] = 'Niepoprawny email lub hasło.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 4 - Zaloguj się</title>

    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 
</head>
<body>
    <main>
        <h1>Zaloguj sie</h1>
        <form method="POST">
            <?php if (isset($errors['_flash'])): ?>
                <div role="alert" style="background: lightpink; color: crimson;">
                    <p><?= $errors['_flash'] ?></p>
                </div>
            <?php endif; ?>
            <div>
                <input type="email" name="user[email]" placeholder="Email">
            </div>
            <div>
                <input type="password" name="user[password]" placeholder="Haslo">
            </div>
            <button type="submit">Zaloguj sie</button>
        </form>
    </main>
</body>
</html>
