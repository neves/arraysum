<?php
error_reporting(E_ALL);

function run($exe, $expected, $input) {
  $descriptorspec = array(
     0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
     1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
     2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
  );

  $process = proc_open($exe, $descriptorspec, $pipes);

  fwrite($pipes[0], $expected.PHP_EOL);
  rsort($input);
  foreach ($input as $n) {
    fwrite($pipes[0], $n.PHP_EOL);
  }
  fwrite($pipes[0], "0\n");
  $output = stream_get_contents($pipes[1]);
  fclose($pipes[0]);
  fclose($pipes[1]);
  proc_close($process);
  list($time, $result) = explode("\n", $output);
  $data = [
    sprintf("%0.8f", doubleval($time)),
    explode(" ", $result)
  ];

  return $data;
}

function run2($exe, $expected, $input) {
  $stdin = fopen('stdin', 'w');
  fwrite($stdin, $expected.PHP_EOL);
  rsort($input);
  foreach ($input as $n) {
    fwrite($stdin, $n.PHP_EOL);
  }
  fwrite($stdin, "0\n");
  fclose($stdin);

  $output = `$exe`;
  list($time, $result) = explode("\n", $output);
  $data = [
    sprintf("%0.8f", doubleval($time)),
    explode(" ", $result)
  ];

  return $data;
}

function run3($exe, $expected, $input) {
  $args = "$expected " . implode(' ', $input);
  $output = `$exe $args`;
  list($time, $result) = explode("\n", $output);
  $data = [
    sprintf("%0.8f", doubleval($time)),
    explode(" ", $result)
  ];

  return $data;
}

//$exe = './array_sum.php';
//$exe = '/Users/neves/Library/Caches/clion10/cmake/generated/f6d7357/f6d7357/Debug/array_sum';
//$exe = './array_sum.rb';
//$exe = './array_sum.coffee';
//$exe = './array_sum.py';
$exe = 'java com.paliari.Main';
$dir = 'times';
$basename = basename($exe);
$target = "$dir/$basename";
@mkdir($dir);
$results = array();
@include $target;

$arrays = glob('arrays/*.php');
sort($arrays);
foreach ($arrays as $f) {
    $name = basename($f, '.php');
    if (isset($results[$name])) continue;
    list($id, $expected) = explode('-', $name);

    $expected = (int)$expected;

    include $f;

    echo $name;
    list($time, $result) = run3($exe, $expected, $notas);
    $sum = array_sum($result);
    if ($sum != $expected) {
      $c = count($notas);
      echo "ERROR: $expected != $sum\t$c\n";
    } else {
      echo "\t $time\n";
      $results[$name] = $time;
      file_put_contents($target, '<?php $results = '.var_export($results, true).";");
      file_put_contents("output-$target", $name . "\t\t" . implode(' ', $result).PHP_EOL, FILE_APPEND);
    }
}
