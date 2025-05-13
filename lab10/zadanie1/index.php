<?php

$name = '__visit_count__';
$duration = 60 * 60 * 24 * 365 * 42; // 42 years

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    setcookie(
        $name, 
        0, 
        [
            'expires' => time() + $duration,
            'httponly' => true,
            'path' => '/',
            'samesite' => 'lax',
        ]
    );
    header("location: {$_SERVER['PHP_SELF']}");
    exit;
}

$count = 1;
if (isset($_COOKIE[$name])) {
    $count = $_COOKIE[$name] + 1;
}

setcookie(
    $name, 
    $count, 
    [
        'expires' => time() + $duration,
        'httponly' => true,
        'path' => '/',
        'samesite' => 'lax',
    ]
);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 1</title>
</head>
<body>
    <main>
        <?php if ($count >= 10): ?>
            <div role="alert">
                Witamy stałego klienta 🫡
            </div>
        <?php endif; ?>

        <dl>
            <dt>Liczba odwiedzin</dt>
            <dd><?= $count ?></dd>
        </dl>

        <form method="POST">
            <button type="submit">Zresetuj licznik odwiedzin</button>
        </form>
    </main>
</body>
</html>
