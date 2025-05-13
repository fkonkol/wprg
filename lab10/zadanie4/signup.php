<?php

require 'functions.php';
require 'Validator.php';

session_start();

if (isset($_SESSION['user'])) {
    header('location: /');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];

    $errors = [];

    if (!Validator::string($user['first_name'], max: 50)) {
        $errors['first_name'] = 'Imie jest wymagane.';
    }

    if (!Validator::string($user['last_name'], max: 50)) {
        $errors['last_name'] = 'Nazwisko jest wymagane.';
    }

    if (!Validator::email($user['email'])) {
        $errors['email'] = 'Podaj poprawny adres email.';
    }

    if (!Validator::password($user['password'])) {
        $errors['password'] = 'Haslo musi skladac sie z cyfry i miec co najmniej 6 znaków.';
    }

    $contents = @file_get_contents('users.json');
    $users = $contents ? json_decode($contents, true) : [];

    if (in_array($user['email'], array_column($users, 'email'))) {
        $errors['email'] = 'Ten adres e-mail jest zajęty.';
    };

    if (count($errors) === 0) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $users[] = $user;
        file_put_contents('users.json', json_encode($users));

        header('location: /');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 4 - Zarejestruj się</title>

    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 
</head>
<body>
    <main>
        <h1>Zarejestruj sie</h1>
        <form method="POST">
            <div>
                <input type="text" name="user[first_name]" placeholder="Imie">
                <?php if (isset($errors['first_name'])): ?>
                    <p style="color: tomato;"><?= $errors['first_name'] ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="user[last_name]" placeholder="Nazwisko">
                <?php if (isset($errors['last_name'])): ?>
                    <p style="color: tomato;"><?= $errors['last_name'] ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="email" name="user[email]" placeholder="Email">
                <?php if (isset($errors['email'])): ?>
                    <p style="color: tomato;"><?= $errors['email'] ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="password" name="user[password]" placeholder="Haslo">
                <?php if (isset($errors['password'])): ?>
                    <p style="color: tomato;"><?= $errors['password'] ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Zarejestruj sie</button>
        </form>
    </main>
</body>
</html>
