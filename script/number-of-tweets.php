<?php

function getNumberOfTweets(){

    $filter = [];
    $mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
    $query = new MongoDB\Driver\Query($filter);
    $rows = $mongo->executeQuery(DB_NAME.'.tweets', $query);

    $nbTweets = 0;
    foreach($rows as $row){
        $nbTweets++;
    }

    return $nbTweets.' tweets';
}