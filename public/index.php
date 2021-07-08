<?php

/**
 * App initialisation
 * $app will have a list of modules
 * $app is a global object
 *
 * Here we will mount our application
 */

use App\Blog\BlogModule;

require '../vendor/autoload.php';

$app = new \Framework\App([

     BlogModule::class
]);

$response  = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

\Http\Response\send($response);
