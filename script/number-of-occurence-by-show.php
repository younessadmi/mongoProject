<?php
require('../config/config.php');

// GET SHOWS TO TRACK
$showsJson = json_decode(file_get_contents('../json/shows.json'), true);
$showOccurence = [];
foreach($showsJson as $show){
    foreach($show as $s){
        foreach($s['hashtags'] as $hashtag){
            if(!isset($showOccurence[$hashtag])){
                $showOccurence[strtolower($hashtag)] = 0;
            }
        }
    }
}
//GET ALL TWEETS
$filter = [];
$mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
$query = new MongoDB\Driver\Query($filter);
$rows = $mongo->executeQuery(DB_NAME.'.tweets', $query);
foreach($rows as $row){
    foreach($row->entities->hashtags as $hashtag){
        if(isset($showOccurence[strtolower($hashtag->text)])){
            $showOccurence[strtolower($hashtag->text)]++;
        }
    }
}
arsort($showOccurence);
//DEFINE THE CHART OPTIONS
$options = [
    'chart' => [
        'type' => 'column'
    ],
    'title' => [
        'text' => 'Number of occurences by show'
    ],
    'subtitle' => [
        'text' => ''
    ],
    'xAxis' => [
        'categories' => array_keys($showOccurence),
        'title' => [
            'text' => null
        ]
    ],
    'series' => [
        [
            'name' => 'Number of tweet',
            'data' => array_values($showOccurence)
        ]
    ]
];
//RETURN THE OPTIONS
echo json_encode($options);
