<?php

/**
 * App initialisation
 * $app will have a list of modules
 * $app is a global object
 * 
 * Here we will mount our application
 */
use App\Blog\BlogModule;

require(dirname(__DIR__).DIRECTORY_SEPARATOR.'init/init.php');
require '../vendor/autoload.php';

/**
 * Renderer
 */
$renderer = new \Framework\Renderer\TwigRenderer(dirname(__DIR__).'/templates');

/**
 * Twig loader and twig env
 */
$loader = new Twig_Loader_Filesystem(dirname(__DIR__).'/templates');
$twig = new Twig_Environment($loader,[
]);

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
