<?php
require('../config/config.php');
require('../vendor/twitteroauth-master/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

// AUTHENTICATION
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$content = $connection->get('account/verify_credentials');

// BUILDING QUERY
$showsJson = json_decode(file_get_contents('../json/shows.json'), true);
$searchQuery = '';
$i = 0;
foreach($showsJson as $show){
    foreach($show as $s){
        foreach($s['hashtags'] as $hashtag){
            $searchQuery = $searchQuery.'#'.$hashtag;
            if(++$i !== count($show)){
                $searchQuery = $searchQuery.'+OR+';
            }
        }
    }
}

// GET TWEETS FROM TWEETER
$insRec = new MongoDB\Driver\BulkWrite(['ordered' => false]);
for($i=8; $i>=0; $i--){
    $date = new DateTime($i.' days ago');
    $tweetOptions = [
        'q' => $searchQuery,
        'count' => 100,
        'until' => $date->format('Y-m-d')
    ];
    $tweets = $connection->get('search/tweets', $tweetOptions);
    foreach($tweets->statuses as $tweet){
        $tweet->_id = $tweet->id_str;
        $insRec->insert($tweet);
    }
}

$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
try{
    $mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
    $mongo->executeBulkWrite(DB_NAME.'.tweets', $insRec, $writeConcern);
}catch(Exception $e){
       
}

// GET NUMBER OF TWEETS FROM DB
include('number-of-tweets.php');
$nbTweets = getNumberOfTweets();

echo json_encode($nbTweets);
