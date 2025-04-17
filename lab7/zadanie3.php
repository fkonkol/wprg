<?php

function foo(int $a, int $b, int $c, int $d) {
  if ($a > $b || $c > $d) {
    return 'BLAD';
  }

  $res = [];
  $idx = $a;
  $n = $c;

  while ($idx <= $b && $n <= $d) {
    $res[$idx++] = $n++;
  }

  return $res;
}

$res = foo(4, 8, 10, 15);
var_export($res);
