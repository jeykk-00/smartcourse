<?php

class Recommender
{
    private $topics = [
        "php" => [
            ["title" => "PHP Official Documentation", "link" => "https://www.php.net/docs.php"],
            ["title" => "PHP W3Schools Tutorial", "link" => "https://www.w3schools.com/php/"]
        ],
        "mysql" => [
            ["title" => "MySQL Official Guide", "link" => "https://dev.mysql.com/doc/"],
            ["title" => "MySQL W3Schools", "link" => "https://www.w3schools.com/mysql/"]
        ],
        "machine learning" => [
            ["title" => "Coursera Machine Learning", "link" => "https://www.coursera.org/learn/machine-learning"],
            ["title" => "Kaggle ML Course", "link" => "https://www.kaggle.com/learn/machine-learning"]
        ],
        "web" => [
            ["title" => "Web Development MDN", "link" => "https://developer.mozilla.org/en-US/docs/Learn"],
            ["title" => "FreeCodeCamp Web Course", "link" => "https://www.freecodecamp.org/"]
        ],
        "javascript" => [
            ["title" => "JavaScript MDN", "link" => "https://developer.mozilla.org/en-US/docs/Web/JavaScript"],
            ["title" => "JavaScript W3Schools", "link" => "https://www.w3schools.com/js/"]
        ]
    ];

    public function getRecommendations($text)
    {
        $text = strtolower($text);
        $found = [];

        foreach ($this->topics as $topic => $resources) {
            if (strpos($text, $topic) !== false) {
                $found = array_merge($found, $resources);
            }
        }

        return $found;
    }
}
