<?php

require_once("vendor/autoload.php");

use \Blog\helper\Check;
use \Blog\helper\Upload;

$app = new \Slim\Slim();
$app->get('/', function () {
    
    
});
$app->run();