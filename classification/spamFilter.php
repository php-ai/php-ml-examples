<?php

declare(strict_types=1);

namespace PhpmlExamples;

include 'vendor/autoload.php';

use Phpml\Dataset\CsvDataset;
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Metric\Accuracy;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;

//temporarily alter the memory limit for such large dataset
ini_set('memory_limit', '-1');

echo 'Loading dataset...' . PHP_EOL;
$dataset = new CsvDataset('data/spam.csv', 1);
$vectorizer = new TokenCountVectorizer(new WordTokenizer());
$tfIdfTransformer = new TfIdfTransformer();

echo 'Extracting samples ...' . PHP_EOL;
$samples = [];
foreach ($dataset->getSamples() as $sample) {
    $samples[] = $sample[0];
}

echo 'Vectorizing samples ...' . PHP_EOL;
$vectorizer->fit($samples);
$vectorizer->transform($samples);

$tfIdfTransformer->fit($samples);
$tfIdfTransformer->transform($samples);

$dataset = new ArrayDataset($samples, $dataset->getTargets());

$randomSplit = new StratifiedRandomSplit($dataset, 0.1);

echo 'Training model ...' . PHP_EOL;
$classifier = new SVC(Kernel::RBF, 1000);
$classifier->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());

echo 'Performing prediction ...' . PHP_EOL;
$predictedLabels = $classifier->predict($randomSplit->getTestSamples());

echo 'Accuracy: '.Accuracy::score($randomSplit->getTestLabels(), $predictedLabels) . PHP_EOL;
