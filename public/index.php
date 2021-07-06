<?php

/**
 * App initialisation
 * $app will have a list of modules
 * $app is a global object
 * 
 * Here we will mount our application
 */
require '../vendor/autoload.php';

$app = new \Framework\App();

$response  = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

\Http\Response\send($response);
