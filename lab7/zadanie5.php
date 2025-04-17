<?php
  final class Validator {
    private array $errors = [];

    public function valid(): bool {
      return empty($this->errors);
    }

    public function errors(): array {
      return $this->errors;
    }

    public function addError(string $field, string $message) {
      if (!array_key_exists($field, $this->errors)) {
        $this->errors[$field] = $message;
      }
    }

    public function check(bool $ok, string $field, string $message) {
      if (!$ok) {
        $this->addError($field, $message);
      }
    }

    public function required(string $value, string $field, string $message) {
      $this->check(trim($value) != "", $field, $message);
    }

    public function numeric(string $value, string $field, string $message) {
      $this->check(is_numeric($value), $field, $message);
    }

    public function in(string $value, array $values, string $field, string $message) {
      $this->check(in_array($value, $values, true), $field, $message);
    }
  }

  class SimpleCalculation {
    private int $first_number;
    private int $second_number;
    private string $operation;

    public function __construct(int $first_number, int $second_number, string $operation) {
      $this->first_number = $first_number;
      $this->second_number = $second_number;
      $this->operation = $operation;
    }

    public function validate(Validator $v, array $input) {
      $v->required($input['first_number'] ?? '', 'first_number', 'Pierwsza liczba jest wymagana.');
      $v->numeric($input['first_number'] ?? '', 'first_number', 'Pierwsza liczba musi być liczbą.');
      $v->required($input['second_number'] ?? '', 'second_number', 'Druga liczba jest wymagana.');
      $v->numeric($input['second_number'] ?? '', 'second_number', 'Druga liczba musi być liczbą.');
      $v->required($input['operation'] ?? '', 'operation', 'Działanie jest wymagane.');
      $v->in($input['operation'] ?? '', ['addition', 'subtraction', 'division', 'multiplication'], 'operation', 'Nieprawidłowe działanie.');
    }

    public function do() {
      if ($this->operation === 'division' && $this->second_number == 0) {
        return 'Dzielenie przez zero niemozliwe.';
      }

      return match ($this->operation) {
        'addition' => $this->first_number + $this->second_number,
        'subtraction' => $this->first_number - $this->second_number,
        'multiplication' => $this->first_number * $this->second_number,
        'division' => $this->first_number / $this->second_number,
        default => 'Ta operacja nie jest obsługiwana',
      };
    }
  }

  class AdvancedCalculation {
    private string $operation;
    private string $value;
  
    public function __construct(string $value, string $operation) {
      $this->value = $value;
      $this->operation = $operation;
    }
  
    public function validate(Validator $v, array $input) {
      $v->required($input['value'] ?? '', 'value', 'Wartość jest wymagana.');
      $v->required($input['operation'] ?? '', 'operation', 'Działanie jest wymagane.');
      $v->in($input['operation'] ?? '', ['cos', 'sin', 'tan', 'bin_to_dec', 'dec_to_bin', 'dec_to_hex', 'hex_to_dec'], 'operation', 'Nieprawidłowe działanie.');
    }
  
    public function do() {
      return match ($this->operation) {
        'cos' => cos(deg2rad((float)$this->value)),
        'sin' => sin(deg2rad((float)$this->value)),
        'tan' => tan(deg2rad((float)$this->value)),
        'bin_to_dec' => bindec($this->value),
        'dec_to_bin' => decbin((int)$this->value),
        'dec_to_hex' => strtoupper(dechex((int)$this->value)),
        'hex_to_dec' => hexdec($this->value),
        default => 'Ta operacja nie jest obslugiwana',
      };
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['calculation'] ?? [];
    $v = new Validator();

    if (($input['type'] ?? '') === 'advanced') {
      $c = new AdvancedCalculation($input['value'] ?? '', $input['operation'] ?? '');
      $c->validate($v, $input);
      if (!$v->valid()) {
        $errors = $v->errors();
      }
      $result = $c->do();
    } else {
      $c = new SimpleCalculation(
        (int)$input['first_number'], 
        (int)$input['second_number'], 
        $input['operation']
      );
      $c->validate($v, $input);
      if (!$v->valid()) {
        $errors = $v->errors();
      }

      $result = $c->do();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kalkulator</title>
</head>
<body>
  <main>
    <h1>Kalkulator</h1>

    <section>
      <h2>Prosty</h2>
      <form method="post">
      <?php if (!empty($errors) && ($input['type'] ?? '') === 'simple'): ?>
          <div style="color: red;">
            <ul>
              <?php foreach ($errors as $field => $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <input type="hidden" name="calculation[type]" value="simple">
        <div>
          <label for="calculation_first_number">Pierwsza liczba</label>
          <input 
            type="number" 
            name="calculation[first_number]" 
            id="calculation_first_number"
          >
        </div>
        <div>
          <label for="calculation_operation">Operacja</label>
          <select name="calculation[operation]" id="calculation_operation">
            <option value="addition">Dodawanie</option>
            <option value="subtraction">Odejmowanie</option>
            <option value="multiplication">Mnozenie</option>
            <option value="division">Dzielenie</option>
          </select>
        </div>
        <div>
          <label for="calculation_second_number">Druga liczba</label>
          <input 
            type="number" 
            name="calculation[second_number]" 
            id="calculation_second_number"
          >
        </div>
        <button type="submit">Oblicz</button>
      </form>
      <?php if (isset($result) && ($input['type'] ?? '') == 'simple'): ?>
        <p>Wynik: <?= htmlspecialchars((string)$result) ?></p>
      <?php endif; ?>
    </section>

    <section>
      <h2>Zaawansowany</h2>
      <form method="post">
        <?php if (!empty($errors) && ($input['type'] ?? '') === 'advanced'): ?>
          <div style="color: red;">
            <ul>
              <?php foreach ($errors as $field => $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <input type="hidden" name="calculation[type]" value="advanced">
        <div>
          <label for="calculation_value">Liczba</label>
          <input 
            type="number" 
            name="calculation[value]" 
            id="calculation_value"
          >
        </div>
        <div>
          <label for="calculation_operation">Operacja</label>
          <select name="calculation[operation]" id="calculation_operation">
            <option value="cos">Cosinus</option>
            <option value="sin">Sinus</option>
            <option value="tan">Tangens</option>
            <option value="bin_to_dec">Binarne na dziesietne</option>
            <option value="dec_to_bin">Dziesietne na binarne</option>
            <option value="dec_to_hex">Dziesietne na szesnastkowe</option>
            <option value="hex_to_dec">Szesnastkowe na dziesietne</option>
          </select>
        </div>
        <button type="submit">Oblicz</button>
      </form>
      <?php if (isset($result) && ($input['type'] ?? '') == 'advanced'): ?>
        <p>Wynik: <?= htmlspecialchars((string)$result) ?></p>
      <?php endif; ?>
    </section>
  </main> 
</body>
</html>
