<?php
require('../config/config.php');

//GET ALL TWEETS
$filter = [];
$mongo = new MongoDB\Driver\Manager(DB_CONNECTION);
$query = new MongoDB\Driver\Query($filter);
$rows = $mongo->executeQuery(DB_NAME.'.tweets', $query);
$colors = [];
foreach($rows as $row){
    if(!isset($colors[$row->user->profile_background_color])){
        $colors[$row->user->profile_background_color] = 0;
    }
    $colors[$row->user->profile_background_color]++;
}
arsort($colors);
$data = [];
foreach($colors as $color => $value) {
    $data[] = ['name' => '#'.$color, 'value' => $value, 'color' => '#'.$color];
}

//DEFINE THE CHART OPTIONS
$options = [
    "series" => [[
        "type" => "treemap",
        "layoutAlgorithm" => 'squarified',
        "alternateStartingDirection" => "true",
        "data" => $data
    ]],
    "title" => [
        "text" => 'User background colors'
    ]
];
//RETURN THE OPTIONS
echo json_encode($options);
