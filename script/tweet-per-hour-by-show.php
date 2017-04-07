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
    if(!isset($data[$date->format('H')])){
        $data[intval($date->format('H'))] = 0;
    }
    $data[intval($date->format('H'))]++;
}
foreach(range(0, 23) as $hour){
    if(!isset($data[$hour])){
        $data[$hour] = 0;
    }
}
ksort($data);

//DEFINE THE CHART OPTIONS
$options = [
    'title' => [
        'text' => 'Tweet per hour',
    ],
    'xAxis' => [
        'categories' => array_keys($data),
     ],
    'plotOptions' => [
        'areaspline' => [
            'marker' => [
                'enabled' => false
            ]
        ]
    ],
    'series' => [
        [
            'type' => 'areaspline',
            'name' => htmlentities($_POST['hashtag']),
            'data' => array_values($data),
        ]
    ]
];
//RETURN THE OPTIONS
echo json_encode($options);
