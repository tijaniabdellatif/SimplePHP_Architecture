<?php

use Framework\ManagerRouter;
use  Framework\Renderer\RendererInterface;

return[
    
    'database.host'=>'localhost',
    'database.username' => 'root',
    'database.password' => '',
    'database.name' => 'PE_blog',
    'views.path' => dirname(__DIR__).'/templates',
    'twig.extensions' => [

        \DI\get(\App\Framework\Router\RouterTwigExtension::class),
        \DI\get(\App\Framework\Twig\TwigPagerExtension::class),
        \DI\get(\App\Framework\Twig\TwigTextExtension::class),
        \DI\get(\App\Framework\Twig\TwigTimeExtension::class)
    ],
    ManagerRouter::class=>\DI\create(ManagerRouter::class),
    RendererInterface::class => \DI\factory(\Framework\Renderer\TwigRendererFactory::class),
    \PDO::class => function(\Psr\Container\ContainerInterface $c){

             return new PDO(
                 'mysql:host='.$c->get('database.host').
                  ';dbname='.$c->get('database.name'),
                   $c->get('database.username'),
                   $c->get('database.password'),
                  [
                      PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
                      PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
                  ]
             );
  }
];


