<?php

$name = $argv[1];

$file = "arrays/$name.php";

list($id, $expected) = explode('-', basename($file, '.php'));
include $file;

rsort($notas);
$somas = [];
for ($i = 0; $i < count($notas); $i++) {
    $somas[] = array_sum(array_slice($notas, $i));
}

printf("
    const int LENGTH   = %s;
    int input[LENGTH]  = {%s};
    int expected = %s;
", count($notas),
   implode(',', $notas),
   $expected);
