<?php

function foo(string $input): string {
  return preg_replace('/[\\\\\/:*?"<>|+\-]/', '', $input);
}

echo foo('*+asd\<>-fgh') . PHP_EOL;
