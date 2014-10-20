<?php

error_reporting(0);
$json = file_get_contents('data.json');
extract(json_decode($json, true));

set_time_limit(10);

require_once 'find_soma.func.php';

$soma = find_soma($total, $notas);

echo json_encode($soma);
