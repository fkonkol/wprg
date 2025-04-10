<?php

function numbers($value){
  $digits = array_filter(str_split($value), fn($rune) => ctype_digit($rune));

  if (empty($digits)) {
    echo "$value: Parameter must be numeric!" . PHP_EOL;
    return;
  }

  $sum = 0;
  foreach ($digits as $digit) {
    $n = (int)$digit;
    if ($sum + $n >= 10) {
      break;
    }
    $sum += $n;
  }

  echo "$value: $sum" . PHP_EOL;
}

numbers(5210);
numbers(-5210);
numbers(5210.5);
numbers("numbers");
