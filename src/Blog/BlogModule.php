<?php


namespace App\Blog;

use App\Blog\Actions\BlogAction;
use Framework\ManagerRouter;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule extends Module
{

    const __DEFINITIONS__ = __DIR__.'/config.php';
    const __MIGRATIONS__ = __DIR__.'/DB/Migrations';
    const __SEEDS__ = __DIR__.'/DB/Seeds';

    public function __construct(string $prefix, ManagerRouter $routemanager, RendererInterface  $renderer)
    {

        $renderer->addPath('blog', __DIR__.'/views');
        $routemanager->get(
            $prefix,
            BlogAction::class,
            'blog.index'
        );

        $routemanager->get(
            $prefix.'/{slug:[a-z\-0-9]+}',
            BlogAction::class,
            'blog.show'
        );
    }
}
