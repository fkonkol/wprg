<?php

function foo(array $arr, int $idx) {
    if ($idx < 0 || $idx > count($arr)) {
        return "BŁAD";
    }
    array_splice($arr, $idx, 0, '$');
    return $arr;
}

$res = foo([0, 1, 2], 1);
var_export($res);
