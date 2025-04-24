<?php

function foo(string $input): int {
  if (strpos($input, '.') !== false) {
      $decimalPart = explode('.', $input)[1];
      return strlen($decimalPart);
  }
  return 0;
}

echo foo('29301.190233') . PHP_EOL;
