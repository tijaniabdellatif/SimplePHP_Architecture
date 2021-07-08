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

$renderer = new \Framework\ManagerRenderer();
$renderer->addPath(dirname(__DIR__).'/templates');
$app = new \Framework\App([

     BlogModule::class
],[

    'renderer' => $renderer
]);

try {
    $response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
} catch (Exception $e) {

    echo 'Errors in : ' .$e->getMessage();
}

\Http\Response\send($response);
