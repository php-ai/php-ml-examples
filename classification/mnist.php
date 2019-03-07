<?php

declare(strict_types=1);

namespace PhpmlExamples;

use Phpml\Classification\SVC;
use Phpml\Dataset\MnistDataset;
use Phpml\Metric\Accuracy;
use Phpml\ModelManager;

require 'vendor/autoload.php';

function convert($size)
{
    $unit=['b','kb','mb','gb','tb','pb'];
    return @round($size/pow(1024, ($i=floor(log($size, 1024)))), 2).' '.$unit[$i];
}

$start = $loadStart = microtime(true);
$trainDataset = new MnistDataset(__DIR__.'/../data/train-images-idx3-ubyte', __DIR__.'/../data/train-labels-idx1-ubyte');
$testDataset = new MnistDataset(__DIR__.'/../data/t10k-images-idx3-ubyte', __DIR__.'/../data/t10k-labels-idx1-ubyte');

echo sprintf('Load time: %s'.PHP_EOL, microtime(true) - $loadStart);

$trainStart = microtime(true);
$classifier = new SVC();
$classifier->train($trainDataset->getSamples(), $trainDataset->getTargets());

echo sprintf('Train time: %s'.PHP_EOL, microtime(true) - $trainStart);

$modelStart = microtime(true);
$modelManager = new ModelManager();
$modelManager->saveToFile($classifier, __DIR__.'/../data/mnist-svm-model.phpml');
echo sprintf('Persist time: %s'.PHP_EOL, microtime(true) - $modelStart);

$predictStart = microtime(true);
$predicted = $classifier->predict($testDataset->getSamples());
echo sprintf('Predict time: %s'.PHP_EOL, microtime(true) - $predictStart);

echo sprintf('Accuracy: %s', Accuracy::score($testDataset->getTargets(), $predicted));
echo sprintf('Total time: %s'.PHP_EOL, microtime(true) - $start);
echo sprintf('Memory: %s', convert(memory_get_peak_usage(true)));
