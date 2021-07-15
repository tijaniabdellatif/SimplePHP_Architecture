<?php

namespace App\Blog;

use App\Blog\Actions\AdminBlogAction;
use App\Blog\Actions\BlogAction;
use Framework\ManagerRouter;
use Framework\Module;
use Framework\Renderer\RendererInterface;

class BlogModule extends Module
{

    const __DEFINITIONS__ = __DIR__.'/config.php';
    const __MIGRATIONS__ = __DIR__.'/DB/Migrations';
    const __SEEDS__ = __DIR__.'/DB/Seeds';

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $blogPrefix = $container->get('blog.prefix');
        $container->get(RendererInterface::class)->addPath('blog', __DIR__.'/views');
        $routemanager = $container->get(ManagerRouter::class);
        $routemanager->get($blogPrefix, BlogAction::class, 'blog.index');
        $routemanager->get(
            $blogPrefix.'/{slug:[a-z\-0-9]+}-{id:[0-9]+}',
            BlogAction::class,
            'blog.show'
        );

        if ($container->has('admin.prefix')) {
            $prefix=$container->get('admin.prefix');
            $routemanager->crud($prefix.'/posts', AdminBlogAction::class, 'blog.admin');
        }
    }
}
