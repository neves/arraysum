<?php

$file = $argv[1];

include $file;

$name = basename($file, '.php');
list($id, $expected) = explode('-', $name);

echo "$expected " . implode(' ', $notas);
