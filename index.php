<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$configs = include('config/config.php');

// Connect to Twitter Model
$tw = new TwitterModel($configs);
$results = $tw->getTweets();
if (!empty($_GET['filter']) && $_GET['filter'] == 1) {
	$results = $tw->getTweetsWithFilter();
}
$tweets = $tw->getTweetsClickableText($results);

// Latte templating engine
$latte = new Latte\Engine;

// Set parameters for template
$params = [
	'results' => $results,
	'tweets' => $tweets,
	'filter' => (!empty($_GET['filter']) && $_GET['filter'] == 1) ? true : false,
];

// Render Latte template
$latte->render('./app/templates/index.latte', $params);
