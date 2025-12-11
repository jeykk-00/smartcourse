<?php 
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/SentimentService.php';
require __DIR__ . '/../src/Recommender.php';

$feedback = '';
$result = null;
$recommendations = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback = trim($_POST['feedback'] ?? '');

    if ($feedback !== '') {
        $sentimentService = new SentimentService();
        $result = $sentimentService->analyze($feedback);

        $recommender = new Recommender();
        // ✅ USE $feedback NOT $input
        $recommendations = $recommender->getRecommendations($feedback);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SmartCourse Feedback Analyzer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>SmartCourse Feedback Analyzer</h1>

        <form method="POST">
            <textarea name="feedback" placeholder="Enter feedback..." required><?php echo htmlspecialchars($feedback); ?></textarea>
            <button type="submit">Analyze</button>
        </form>

        <?php if ($result !== null): ?>
            <div class="result">
                <h2>Sentiment: <?php echo htmlspecialchars($result['sentiment']); ?></h2>

                <h3>Keywords:</h3>
                <?php if (!empty($result['keywords'])): ?>
                    <ul>
                        <?php foreach ($result['keywords'] as $keyword): ?>
                            <li><?php echo htmlspecialchars($keyword); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No keywords found.</p>
                <?php endif; ?>

                <h3>Recommended Resources:</h3>
                <?php if (!empty($recommendations)): ?>
                    <ul>
                        <?php foreach ($recommendations as $rec): ?>
                            <?php if (is_array($rec)): ?>
                                <li>
                                    <a href="<?php echo htmlspecialchars($rec['link']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($rec['title']); ?>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li><?php echo htmlspecialchars($rec); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No recommendations found.</p>
                <?php endif; ?>

            </div>
        <?php endif; ?>
    </div>
</body>
</html>
