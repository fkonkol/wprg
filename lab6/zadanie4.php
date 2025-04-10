<?php

function multiplyMatricesAndPrint(array $A, array $B): void {
  $rowsA = count($A);
  $colsA = count($A[0]);
  $rowsB = count($B);
  $colsB = count($B[0]);

  if ($rowsA !== $rowsB || $colsA !== $colsB) {
      echo "Wymiary są niezgodne" . PHP_EOL;
      return;
  }

  $result = [];
  for ($i = 0; $i < $rowsA; $i++) {
      for ($j = 0; $j < $colsA; $j++) {
        $result[$i][$j] = $A[$i][$j] + $B[$i][$j];
        echo $result[$i][$j] . " ";
      }
      echo PHP_EOL;
  }
}

$A = [
  [1, 2],
  [3, 4]
];

$B = [
  [5, 6],
  [7, 8]
];

multiplyMatricesAndPrint($A, $B);
