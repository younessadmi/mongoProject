<?php
require('../config/config.php');
require('../vendor/twitteroauth-master/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

// AUTHENTICATION
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$content = $connection->get('account/verify_credentials');

// GET TWEETS
$tweetOptions = [
    'q' => '#netflix',
    'count' => 100
];
$tweets = $connection->get('search/tweets', $tweetOptions);
$mongo = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$insRec = new MongoDB\Driver\BulkWrite;

foreach($tweets->statuses as $tweet){
    $tweet->_id = $tweet->id;
    $insRec->insert($tweet);
}
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
$result = $mongo->executeBulkWrite('mongo-project.tweets', $insRec, $writeConcern);

echo json_encode($result);