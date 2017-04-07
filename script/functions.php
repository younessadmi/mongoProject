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

    return $nbTweets.' <i class="fa fa-twitter fa-fw" aria-hidden="true"></i>';
}

function getListOfShows(){
    $showsJson = json_decode(file_get_contents('json/shows.json'), true);
    $shows = [];
    foreach($showsJson as $show){
        foreach($show as $s){
            foreach($s['hashtags'] as $hashtag){
                if(!in_array($hashtag, $shows)){
                    $shows[] = strtolower($hashtag);
                }
            }
        }
    }
    sort($shows);
    return $shows;
}
