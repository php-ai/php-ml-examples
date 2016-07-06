<?php

include 'vendor/autoload.php';

use Phpml\Dataset\CsvDataset;
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Metric\Accuracy;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;

$dataset = new CsvDataset('data/languages.csv', 1);
$vectorizer = new TokenCountVectorizer(new WordTokenizer());

$samples = [];
foreach ($dataset->getSamples() as $sample) {
    $samples[] = $sample[0];
}

$vectorizer->transform($samples);
$dataset = new ArrayDataset($samples, $dataset->getTargets());

$randomSplit = new RandomSplit($dataset, 0.25);

$classifier = new SVC(Kernel::RBF, 100);
$classifier->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());

$predictedLabels = $classifier->predict($randomSplit->getTestSamples());

echo Accuracy::score($randomSplit->getTestLabels(), $predictedLabels);
