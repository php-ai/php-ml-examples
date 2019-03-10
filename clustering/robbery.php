<?php

declare(strict_types=1);

namespace PhpmlExamples;

use Phpml\Clustering\KMeans;

require 'vendor/autoload.php';

$lines = file(__DIR__.'/../data/crimes-robbery.csv');
foreach ($lines as &$line) {
    $row = explode(';', $line);
    $line = [(float) $row[0], (float) $row[1]];
}

$clusterer = new KMeans(14);
$clusters = $clusterer->cluster($lines);

$lines = [];
foreach ($clusters as $key => $cluster) {
    foreach ($cluster as $sample) {
        $lines[] = sprintf('%s;%s;%s', $key, $sample[0], $sample[1]);
    }
}

file_put_contents(__DIR__ . '/../data/crimes-robbery-clusters.csv', implode(PHP_EOL, $lines));
