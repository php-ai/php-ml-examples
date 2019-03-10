<?php

$handle = fopen(__DIR__.'/../data/crimes.csv', 'r');
$header = fgetcsv($handle);

$lines = [];
$index = 0;
$filter = ['ARSON'];
while (($row = fgetcsv($handle)) !== false) {
    if(!in_array($row[6], $filter)) {
        continue;
    }

    if(!is_numeric($row[20]) || !is_numeric($row[21])) {
        continue;
    }

    if((float) $row[21] < -90) {
        continue;
    }

    $lines[] = sprintf('%s;%s', $row[20], $row[21]);
}
fclose($handle);

file_put_contents(__DIR__ . '/../data/crimes-arson.csv', implode(PHP_EOL, $lines));

