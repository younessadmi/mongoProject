<?php
require('../config/config.php');
require('../vendor/twitteroauth-master/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

// AUTHENTICATION
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$content = $connection->get('account/verify_credentials');

// GET TWEETS
$tweetOptions = [
    'q' => '#oitnb+OR+#houseofcards',
    'count' => 100
];
$tweets = $connection->get('search/tweets', $tweetOptions);
$mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
$insRec = new MongoDB\Driver\BulkWrite(['ordered' => false]);

foreach($tweets->statuses as $tweet){
    $tweet->_id = $tweet->id_str;
    $insRec->insert($tweet);
}

$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
$result = $mongo->executeBulkWrite(DB_NAME.'.tweets', $insRec, $writeConcern);

echo json_encode($result);
