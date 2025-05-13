<?php

$hasVoted = isset($_COOKIE['__has_voted']);
$showMessage = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($hasVoted) {
        $showMessage = true;
    } else {
        setcookie('__has_voted', 'yes', ['expires' => time() + 3600]);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadanie 2</title>
</head>
<body>
    <main>
        <?php if ($showMessage): ?>
            <p>Juz oddałeś głos wcześniej...</p>
        <?php endif; ?>
        <form method="POST">
            <fieldset>
                <legend>Co wolisz?</legend>

                <div>
                    <input type="radio" id="psy" name="answer" value="psy">
                    <label for="psy">Psy</label>
                </div>

                <div>
                    <input type="radio" id="koty" name="answer" value="koty">
                    <label for="koty">Koty</label>
                </div>

                <button type="submit">Zagłosuj</button>
            </fieldset> 
        </form>
    </main> 
</body>
</html>
