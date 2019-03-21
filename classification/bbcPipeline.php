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
use Phpml\ModelManager;
use Phpml\Pipeline;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\NGramTokenizer;

include 'vendor/autoload.php';

$dataset = new FilesDataset(__DIR__.'/../data/bbc');
$split = new StratifiedRandomSplit($dataset, 0.1);


$pipeline = new Pipeline([
    new TokenCountVectorizer($tokenizer = new NGramTokenizer(1, 3), new English()),
    new TfIdfTransformer()
], new SVC(Kernel::LINEAR));

$start = microtime(true);
$pipeline->train($split->getTrainSamples(), $split->getTrainLabels());
$stop = microtime(true);

$predicted = $pipeline->predict($split->getTestSamples());

echo 'Train: ' . round($stop - $start, 4) . 's'. PHP_EOL;
echo 'Estimator: ' . get_class($pipeline->getEstimator()) . PHP_EOL;
echo 'Tokenizer: ' . get_class($tokenizer) . PHP_EOL;
echo 'Accuracy: ' . Accuracy::score($split->getTestLabels(), $predicted);

$modelManager = new ModelManager();
$modelManager->saveToFile($pipeline, __DIR__.'/../model/bbc-nb.phpml');
