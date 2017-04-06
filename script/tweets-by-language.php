<?php
require('../config/config.php');

//GET ALL TWEETS
$filter = [];
$mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
$query = new MongoDB\Driver\Query($filter);
$rows = $mongo->executeQuery(DB_NAME.'.tweets', $query);
$languages = [];
foreach($rows as $row){
    if($row->lang != "und"){
        if(!isset($languages[$row->lang])){
            $languages[$row->lang] = 1;
        } else {
            $languages[$row->lang]++;
        }
    }
}
arsort($languages);
$data = [];
foreach($languages as $language => $value) {
    $data[] = ['name' => $language, 'y' => $value];
}

//DEFINE THE CHART OPTIONS
$options = [
    'chart' => [
        'type' => 'pie'
    ],
    'title' => [
        'text' => 'Tweets by language'
    ],
    'plotOptions' => [
        'pie' => [
            'allowPointSelect' => true,
            'cursor' => 'pointer',
            'dataLabels' => [
                'enabled' => false
            ],
            'showInLegend' => true
        ]
    ],
    'series' => [[
        'name' => 'Number of tweets',
        'data' => $data
    ]]
];
//RETURN THE OPTIONS
echo json_encode($options);
