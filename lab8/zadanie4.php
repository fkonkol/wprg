<?php

function foo(string $input): int {
    $vowels = ['a', 'e', 'i', 'o', 'u'];
    $count = 0;

    foreach (str_split(strtolower($input)) as $char) {
        if (in_array($char, $vowels)) {
            $count++;
        }
    }

    return $count;
}

echo foo('aeiouzxcv') . PHP_EOL;
