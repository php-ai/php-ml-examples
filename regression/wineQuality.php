<?php

declare(strict_types=1);

namespace PhpmlExamples;

include 'vendor/autoload.php';

use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\Demo\WineDataset;
use Phpml\Metric\Accuracy;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;

$dataset = new WineDataset();
$split = new StratifiedRandomSplit($dataset);

$regression = new SVR(Kernel::RBF, 3, 0.1, 10);
$regression->train($split->getTrainSamples(), $split->getTrainLabels());

$predicted = $regression->predict($split->getTestSamples());

// predicted target are regression result so to test accuracy we must round them

foreach ($predicted as &$target) {
    $target = round($target, 0);
}

echo 'Accuracy: '.Accuracy::score($split->getTestLabels(), $predicted);
