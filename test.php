<?php

require 'ArraySum.php';

$notas = [13, 8, 6, 3, 1];

$soma = new ArraySum($notas);

$soma->test(32, []);
$soma->test(31, $notas);
$soma->test(13, [13]);
$soma->test(8, [8]);
$soma->test(6, [6]);
$soma->test(3, [3]);
$soma->test(1, [1]);
$soma->test(21, [13, 8]);
$soma->test(19, [13, 6]);
$soma->test(14, [8, 6]);
$soma->test(30, [13, 8, 6, 3]);
$soma->test(20, [13, 6, 1]);
$soma->test(23, [13, 6, 3, 1]);
$soma->test(2, []);
$soma->test(16, [13, 3]);
