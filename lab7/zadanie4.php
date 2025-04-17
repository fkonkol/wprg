<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zarejestruj się</title>
</head>
<body>
  <main>
    <section>
      <form method="POST">
        <div>
          <label for="user_first_name">Imię:</label>
          <input type="text" name="user[first_name]" id="user_first_name" required>
        </div>
        <div>
          <label for="user_last_name">Nazwisko:</label>
          <input type="text" name="user[last_name]" id="user_last_name" required>
        </div>
        <div>
          <label for="user_email">Adres email:</label>
          <input type="email" name="user[email]" id="user_email" required>
        </div>
        <div>
          <label for="user_password">Hasło:</label>
          <input type="password" name="user[password]" id="user_password" required>
        </div>
        <div>
          <label for="user_password_confirmation">Potwierdz haslo:</label>
          <input type="password" name="user[password_confirmation]" id="user_password_confirmation" required>
        </div>
        <div>
          <label for="user_age">Wiek:</label>
          <input type="number" name="user[age]" id="user_age" min="18" max="100" required>
        </div>
        <button type="submit">Zarejestruj się</button>
      </form>
    </section>

    <?php if (isset($user)): ?>
      <table>
        <tr>
          <th>Imie</th>
          <th>Nazwisko</th>
          <th>Email</th>
          <th>Wiek</th>
        </tr>
        <tr>
          <td><?= htmlspecialchars($user['first_name']) ?></td>
          <td><?= htmlspecialchars($user['last_name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['age']) ?></td>
        </tr>
      </table>
    <?php endif; ?>
  </main> 
</body>
</html>
