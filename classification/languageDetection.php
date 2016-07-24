<?php

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

$dataset = new CsvDataset('data/languages.csv', 1);
$vectorizer = new TokenCountVectorizer(new WordTokenizer());
$tfIdfTransformer = new TfIdfTransformer();

$samples = [];
foreach ($dataset->getSamples() as $sample) {
    $samples[] = $sample[0];
}

$vectorizer->fit($samples);
$vectorizer->transform($samples);

$tfIdfTransformer->fit($samples);
$tfIdfTransformer->transform($samples);

$dataset = new ArrayDataset($samples, $dataset->getTargets());

$randomSplit = new StratifiedRandomSplit($dataset, 0.1);

$classifier = new SVC(Kernel::RBF, 10000);
$classifier->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());

$predictedLabels = $classifier->predict($randomSplit->getTestSamples());

echo 'Accuracy: '.Accuracy::score($randomSplit->getTestLabels(), $predictedLabels);
