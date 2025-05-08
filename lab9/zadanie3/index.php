<?php

$counterPath = './counter.txt';

if (!is_file($counterPath) && file_put_contents($counterPath, 1) === false) {
    echo 'Something went wrong. Try again later.';
    die;
}

$count = (int) file_get_contents($counterPath);

if (file_put_contents($counterPath, $count + 1) === false) {
    echo 'Something went wrong. Try again later.';
    die;
}

echo $count; 
