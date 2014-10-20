#!/usr/bin/env php
<?php

require_once 'ArraySumFixed.php';

$valores = [];
array_shift($argv);
$valores = array_map('intval', $argv);
$total = array_shift($valores);

$as = new ArraySum($valores);
$start = microtime(true);
$as->find($total);
$result = $as->result();
printf("%f\n", microtime(true) - $start);
echo implode(" ", $result) . PHP_EOL;
