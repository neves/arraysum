<?php

require 'ArraySum.php';
$list = '306 29888 2335 22685 18750 18747 18744 29888 306 3075 38925 40367 50588 51399 56629 60439 61627 61628 35127 62257 65752 73820 7596';
$list = '2335';
$ignore = explode(' ', $list);
$arrays = glob('arrays/*.php');
//$arrays = ['arrays/73820-84120.php'];
foreach ($arrays as $f) {
    $name = basename($f, '.php');
    list($id, $total) = explode('-', $name);
    //if (in_array($id, $ignore)) continue;
    $total = (int)$total;
    include $f;
    $soma = new ArraySum($notas);

    $start = microtime(true);
    printf("%s\t%4d notas", $name, count($notas));
    echo PHP_EOL;
    $result = $soma->filter($total);
    echo PHP_EOL;
    printf("\t%s %11s loops\t%0.3fs\n", array_sum($result) == $total ? 'ok' : 'ERROR', number_format($soma->count), microtime(true) - $start);
}

exit;
include 'arrays/52864-61850.php';
$soma = new Soma($notas);

//$soma->test(61850);exit;


// [ soma de 2 numeros
//   [0] 21,
//   [1] 19,
//   [2] 17,
//   [3] 15,
//   [4] 12,
//   [5] 10,
//   [6] 8,
//   [7] 6,
//   [8] 4
// ]

// [ soma de 3 numeros
//   [0] 26,
//   [1] 24,
//   [2] 22,
//   [3] 20,
//   [4] 18,
//   [5] 15,
//   [6] 13,
//   [7] 11,
//   [8] 9
// ]

// [ soma de 4 numeros
//   [0] 29,
//   [1] 27,
//   [2] 25,
//   [3] 23,
//   [4] 16
// ]

$somas = [30, 16, 9, 4, 1];
