<?php

declare(strict_types=1);

namespace PhpmlExamples;

use Phpml\Classification\KNearestNeighbors;
use Phpml\Dataset\CsvDataset;

include 'vendor/autoload.php';

$dataset = new CsvDataset(__DIR__.'/../data/air.csv', 2, false, ';');

foreach (range(1, 10) as $k) {
    $correct = 0;
    foreach ($dataset->getSamples() as $index => $sample) {
        $estimator = new KNearestNeighbors($k);
        $estimator->train($other = removeIndex($index, $dataset->getSamples()), removeIndex($index, $dataset->getTargets()));

        $predicted = $estimator->predict([$sample]);

        if ($predicted[0] === $dataset->getTargets()[$index]) {
            $correct++;
        }
    }

    echo sprintf('Accuracy (k=%s): %.02f%% correct: %s', $k, ($correct / count($dataset->getSamples())) * 100, $correct) . PHP_EOL;
}

function removeIndex($index, $array): array
{
    unset($array[$index]);
    return $array;
}
