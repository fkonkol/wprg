<?php

// print_primes prints all prime numbers in range <a; b> or <b; a>.
function print_primes($a, $b): void {
    $is_prime = function(int $n): bool {
        if ($n < 2) {
            return false;
        }

        for ($i = 2; $i <= sqrt($n); $i++) {
            if ($n % $i === 0) {
                return false;
            }
        }
        return true;
    };

    if (!is_numeric($a) || !is_numeric($b)) {
        echo "$a, $b: Start and stop must be numeric!\n";
        return;
    }

    echo "$a, $b: ";
    if ($a < 0 || $b < 0) {
        echo "Start and stop must be positive number! Given $a, $b!\n";
        return;
    }

    if ($a > $b) {
        [$a, $b] = [$b, $a];
    }

    $a = (int)ceil($a);
    $b = (int)floor($b);

    for ($i = $a; $i <= $b; $i++) {
        if ($is_prime($i)) {
            echo "$i "; 
        }
    }
    echo "\n";
}

print_primes(5, 10);
print_primes(10, 5);
print_primes(5.5, 10);
print_primes(-5, 10);
print_primes('prime', 10);
