<?php

class User
{
  public function __construct(private DateTimeImmutable $birthdate) {}

  public function birthdate(): DateTimeImmutable
  {
    return $this->birthdate;
  }

  public function age(): int
  {
    return $this->birthdate->diff(new DateTimeImmutable)->y;
  }

  public function nextBirthday(): DateTimeImmutable
  {
    $today = new DateTimeImmutable;
    $year = $today->format('Y');

    $nextBirthday = new DateTimeImmutable(
      $year . '-' . date('m-d', strtotime($this->birthdate->format('Y-m-d')))
    );

    if ($nextBirthday < $today) {
      $nextBirthday = $nextBirthday->modify('+1 year');
    }

    return $nextBirthday;
  }

  public function nextBirthdayCount(): int
  {
    return new DateTimeImmutable()->diff($this->nextBirthday())->days;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $birthdate = $_GET['birthdate'] ?? '';

  if (!$birthdate) {
    die;
  }

  $user = new User(new DateTimeImmutable($birthdate));
}
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
    <form method="get">
      <label for="birthdate">Date of birth</label>
      <input type="date" name="birthdate" id="birthdate" required min="1920-01-01" max="<?= new DateTime()->format('Y-m-d') ?>">
      <button type="submit">Submit</button>

      <output>
        <?php if (isset($user)): ?>
          <p>You're <?= $user->age() ?> year(s) old.</p>
          <p>You were born on <?= $user->birthdate()->format('l') ?>.</p>
          <p>Your next birthday is in <?= $user->nextBirthdayCount() ?> day(s).</p>
        <?php endif; ?>
      </output>
    </form>
  </main>    
</body>
</html>