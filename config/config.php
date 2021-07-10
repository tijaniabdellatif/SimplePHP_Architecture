<?php

use Framework\ManagerRouter;
use  Framework\Renderer\RendererInterface;

return[
    
    
    'views.path' => dirname(__DIR__).'/templates',
    'twig.extensions' => [

        \DI\get(\App\Framework\Router\RouterTwigExtension::class)
    ],
    ManagerRouter::class=>\DI\create(ManagerRouter::class),
    RendererInterface::class => \DI\factory(\Framework\Renderer\TwigRendererFactory::class)

];


