<?php

declare(strict_types=1);

namespace PhpmlExamples;

use Phpml\Clustering\KMeans;
use Phpml\Math\Distance\Euclidean;

require 'vendor/autoload.php';

$lines = file(__DIR__.'/../data/syntetic-g.csv');
foreach ($lines as &$line) {
    $row = explode(',', $line);
    $line = [(float) $row[0], (float) $row[1]];
}

function squaredDistances($center, $points): float
{
    $sum = 0;
    $metric = new Euclidean();
    foreach ($points as $point) {
        $sum += $metric->sqDistance($center, $point);
    }

    return $sum;
}


for ($i=1; $i<21; $i++) {
    $clusterer = new KMeans($i);
    $clusters = $clusterer->cluster($lines);
    $centronoids = $clusterer->centronoids();

    $sum = 0;
    foreach ($centronoids as $key => $centronoid) {
        $sum += squaredDistances($centronoid, $clusters[$key]);
    }

    echo sprintf('SSE (k=%s): %f' . PHP_EOL, $i, $sum);
}
