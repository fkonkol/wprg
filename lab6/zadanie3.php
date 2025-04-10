<?php

function sequences_n($first, $factor, $length){
    if (!is_numeric($first) || !is_numeric($factor) || !is_numeric($length)) {
        echo "$first, $factor, $length: Parameters must be numeric!" . PHP_EOL . PHP_EOL;
        return;
    }

    if ($length < 1) {
        echo "$first, $factor, $length: N must be positive number!" . PHP_EOL . PHP_EOL;
        return;
    }

    echo "$first, $factor, $length" . PHP_EOL;

    echo "Arithmetic: ";
    $arith = $first;
    for ($i = 0; $i < $length; $i++){
        echo $arith . " ";
        $arith += $factor;
    }
    echo PHP_EOL;

    $geom = $first;
    echo "Geometric: ";
    for ($i = 0; $i < $length; $i++){
        echo $geom . " ";
        $geom *= $factor;
    }
    echo PHP_EOL . PHP_EOL;
}

sequences_n(5, 2, 10);
sequences_n(5, -2, 10);
sequences_n(-5, 2, 10);
sequences_n(5, 2.5, 5);
sequences_n(5, 2, -10);
sequences_n("start", 2, 10);
