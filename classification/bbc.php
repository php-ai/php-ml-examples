<?php

declare(strict_types=1);

namespace PhpmlExamples;

use Phpml\Classification\SVC;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\FilesDataset;
use Phpml\FeatureExtraction\StopWords\English;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Metric\Accuracy;
use Phpml\Tokenization\NGramTokenizer;

include 'vendor/autoload.php';

$dataset = new FilesDataset(__DIR__.'/../data/bbc');
$split = new StratifiedRandomSplit($dataset, 0.3);

$samples = $split->getTrainSamples();

$vectorizer = new TokenCountVectorizer(new NGramTokenizer(1, 3), new English());
$vectorizer->fit($samples);
$vectorizer->transform($samples);

$transformer = new TfIdfTransformer();
$transformer->fit($samples);
$transformer->transform($samples);

$classifier = new SVC();
$classifier->train($samples, $split->getTrainLabels());


$testSamples = $split->getTestSamples();
$vectorizer->transform($testSamples);
$transformer->transform($testSamples);

$predicted = $classifier->predict($testSamples);

echo 'Accuracy: ' . Accuracy::score($split->getTestLabels(), $predicted);
