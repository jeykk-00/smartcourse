<?php
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\Classification\NaiveBayes;

class SentimentService {
    private $model;
    private $vectorizer;

    public function __construct() {
        // Load trained model if exists
        if (file_exists(__DIR__ . '/../models/model.serialized')) {
            $this->model = unserialize(file_get_contents(__DIR__ . '/../models/model.serialized'));
            $this->vectorizer = unserialize(file_get_contents(__DIR__ . '/../models/vectorizer.serialized'));
        } else {
            $this->model = null;
            $this->vectorizer = null;
        }
    }

    public function analyze(string $text): array {
        $keywords = $this->extractKeywords($text);

        if ($this->model && $this->vectorizer) {
            // Transform text into numeric features
            $samples = [$text]; // must be an array
            $this->vectorizer->transform($samples); // numeric features in $samples

            // Predict sentiment using trained model
            $sentiment = $this->model->predict($samples)[0];
        } else {
            // simple heuristic fallback
            $positiveWords = ['good','great','excellent','happy','love'];
            $negativeWords = ['bad','poor','sad','hate','problem'];
            $sentiment = 'Neutral';
            foreach ($positiveWords as $w) {
                if (stripos($text, $w) !== false) { $sentiment = 'Positive'; break; }
            }
            foreach ($negativeWords as $w) {
                if (stripos($text, $w) !== false) { $sentiment = 'Negative'; break; }
            }
        }

        return [
            'sentiment' => $sentiment,
            'keywords' => $keywords
        ];
    }

    private function extractKeywords(string $text): array {
        $words = array_count_values(str_word_count(strtolower($text), 1));
        arsort($words);
        return array_slice(array_keys($words), 0, 5);
    }
}

