<?php
require('../config/config.php');

//GET TWEET TAGGED WITH THE HASHTAG POSTED
if($_POST['hashtag'] != 'All'){
    $filter = [
        'entities.hashtags.text' => $_POST['hashtag']
    ];
}else{
    $filter = [];   
}
$mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
$query = new MongoDB\Driver\Query($filter);
$rows = $mongo->executeQuery(DB_NAME.'.tweets', $query);
$data = [];
foreach($rows as $row){
    $date = DateTime::createFromFormat('D M d H:i:s O Y', $row->created_at); // Thu Apr 06 19:11:39 +0000 2017
    if(!isset($data[$date->getTimestamp()*1000])){
        $data[strval($date->getTimestamp()*1000)] = 1;
    }else{
        $data[strval($date->getTimestamp()*1000)]++;
    }
}
ksort($data);
$dataSeries = [];
foreach($data as $timestamp => $nbTweet){
    $dataSeries[] = [
        floatval($timestamp),
        $nbTweet
    ];
}


//DEFINE THE CHART OPTIONS
$options = [
    'title' => [
        'text' => 'Tweet per hour'
    ],
    'series' => [
        [
            'type' => 'area',
            'name' => htmlentities($_POST['hashtag']),
            'data' => $dataSeries,
            'dataGrouping' => [
                'smoothed' => true,
                'enabled' => false
            ]
        ]
    ]
];
//RETURN THE OPTIONS
echo json_encode($options);
