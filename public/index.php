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


$modules = [

     BlogModule::class
];

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) .'/config/config.php');


foreach($modules as $module){

     if($module::__DEFINITIONS__){

           $builder->addDefinitions($module::__DEFINITIONS__);
     }
}

$builder->addDefinitions(dirname(__DIR__) . '/config.php');
$container = $builder->build();


$app = new \Framework\App($container,$modules);

try {
    $response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
} catch (Exception $e) {

    return $e->getMessage();
}
\Http\Response\send($response);
