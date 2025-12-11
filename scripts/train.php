<?php
require __DIR__ . '/../vendor/autoload.php';

use Phpml\Classification\NaiveBayes;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;

// Sample training data
$samples = [
    'I love this course',
    'This course is excellent',
    'I hate this course',
    'The course is bad',
    'I feel happy about this course',
    'This is a poor course'
];

$labels = [
    'Positive',
    'Positive',
    'Negative',
    'Negative',
    'Positive',
    'Negative'
];

// Vectorize text into numerical features
$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
$vectorizer->fit($samples);
$vectorizer->transform($samples); // converts text to numeric arrays

// Train the Naive Bayes classifier
$model = new NaiveBayes();
$model->train($samples, $labels);

// Save model and vectorizer
if (!file_exists(__DIR__ . '/../models')) {
    mkdir(__DIR__ . '/../models');
}

file_put_contents(__DIR__ . '/../models/model.serialized', serialize($model));
file_put_contents(__DIR__ . '/../models/vectorizer.serialized', serialize($vectorizer));

echo "Training complete. Model saved to models/ folder.\n";
