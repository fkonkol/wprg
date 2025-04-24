<?php

function foo(string $input): void {
  echo strtoupper($input) . PHP_EOL;
  echo strtolower($input) . PHP_EOL;
  echo ucfirst(strtolower($input)) . PHP_EOL;
  echo ucwords(strtolower($input)) . PHP_EOL;
}

foo('The quick brown fox jumps over the lazy dog');


