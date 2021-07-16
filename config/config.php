<?php

use App\Framework\Router\RouterTwigExtension;
use App\Framework\Session\PHPSession;
use App\Framework\Session\SessionInterface;
use App\Framework\Twig\TwigAssetExtension;
use App\Framework\Twig\TwigFlashExtension;
use App\Framework\Twig\TwigPagerExtension;
use App\Framework\Twig\TwigTextExtension;
use App\Framework\Twig\TwigTimeExtension;
use Framework\ManagerRouter;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Psr\Container\ContainerInterface;

return[
    
    'database.host'=>'localhost',
    'database.username' => 'root',
    'database.password' => '',
    'database.name' => 'PE_blog',
    'views.path' => dirname(__DIR__).'/templates',
    'twig.extensions' => [

        \DI\get(RouterTwigExtension::class),
        \DI\get(TwigPagerExtension::class),
        \DI\get(TwigTextExtension::class),
        \DI\get(TwigTimeExtension::class),
        \DI\get(TwigAssetExtension::class),
        \DI\get(TwigFlashExtension::class)
    ],
    SessionInterface::class=>\DI\create(PHPSession::class),
    ManagerRouter::class=>\DI\create(ManagerRouter::class),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    \PDO::class => function (ContainerInterface $c) {

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
