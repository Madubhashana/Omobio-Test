<?php

use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require './vendor/autoload.php';
require './src/config/db.php';

$app = new \Slim\App();




//customer routes
require './src/routes/auth.php';

$app->run();
