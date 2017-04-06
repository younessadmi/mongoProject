<?php
// PREREQUISITE
if(!file_exists('config/config.php')){
    die('You must create the config/config.php file');    
}
if(!extension_loaded('mongodb')){
    die('Mongo php extension is not loaded');
}
require('config/config.php');
require('script/functions.php');