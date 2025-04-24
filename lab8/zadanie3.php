<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = $_POST['body'];
    $action = $_POST['action'];

    $result = null;
    $error = null;

    if (!in_array($action, ['reverse', 'uppercase', 'lowercase', 'count', 'trim'])) {
      http_response_code(422);
      $error = 'Sprawdz poprawnosc przesylanych danych.';
    } else {
      $result = match ($action) {
        'reverse' => strrev($body), /* Nie działa poprawnie w przypadku znaków unicode */
        'uppercase' => mb_strtoupper($body, 'UTF-8'),
        'lowercase' => mb_strtolower($body, 'UTF-8'),
        'count' => mb_strlen($body, 'UTF-8'),
        'trim' => trim($body),
      };
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');

    *, *::before, *::after {
      box-sizing: border-box;
    }

    * {
      margin: 0;
    }

    input, button, textarea, select {
      font: inherit;
    }

    body {
      font-family: 'Lato', sans-serif;
      font-size: 1.1rem;
      line-height: 1.5;
    }
    
    button {
      appearance: none;
      display: inline-block;
      background-color: #1fa1f8;
      padding: 0.5em 1em;
      border-radius: 1rem;
      border: none;
      cursor: pointer;
      transition: all 300ms;
      font-weight: 500;
      color: #fff;
    }

    button:active {
      transform: scale(0.98);
    }

    textarea {
      resize: none;
    }

    input, textarea, select {
      width: 100%;
      padding: 0.75rem;
      border-radius: 1rem;
      border: 1px solid #e5e5e5;
    }
    
    button:hover {
      filter: brightness(1.1);
    }

    output {
      margin: 0;
      border: 1px dashed #e5e5e5;
      border-radius: 1rem;
      padding: 1rem;
    }

    div[role="alert"] {
      padding: 1rem;
      background: pink;
      color: crimson;
      border-radius: 1rem;
    }

    /* Utilities */

    .fs-heading {
      font-size: 1.75rem;
    }

    .container {
      width: min(90%, 32rem);
      margin-inline: auto;
    }

    .page-layout {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      min-height: 100dvh;
    }

    .visually-hidden {
      clip: rect(0 0 0 0);
      clip-path: inset(50%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap;
      width: 1px;
    }

    .grid-flow {
      display: grid;
      gap: 1rem;
    }
  </style>
</head>
<body>
  <main class="page-layout">
    <div class="container grid-flow">
      <h1 class="fs-heading">Konwerter tekstu</h1>
      <form method="post" class="grid-flow">
        <?php if (isset($error)): ?>
          <div role="alert">
            <p><?= $error ?></p>
          </div>
        <?php endif; ?>

        <label for="body" class="visually-hidden">Tekst do przetworzenia</label>
        <textarea name="body" id="body" placeholder="Twój tekst"></textarea>

        <label for="action" class="visually-hidden">Operacja</label>
        <select name="action" id="action">
          <option value="reverse">Odwrócenie ciągu znaków</option>
          <option value="uppercase">Zamiana wszystkich liter na wielkie</option>
          <option value="lowercase">Zamiana wszystkich liter na małe</option>
          <option value="count">Liczenie liczby znaków</option>
          <option value="trim">Usuwanie białych znaków</option>
        </select>

        <button type="submit">Wykonaj</button>

        <?php if (isset($result)): ?>
          <output>
            <pre><code><?= htmlspecialchars($result) ?></code></pre>
          </output>
        <?php endif; ?>
      </form>
    </div>
  </main> 
</body>
</html>
