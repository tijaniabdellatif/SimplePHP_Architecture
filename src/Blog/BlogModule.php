<?php


namespace App\Blog;

use Framework\ManagerRouter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{

    public function __construct(ManagerRouter $routemanager)
    {
        $routemanager->get(
            '/blog',
            [$this,'index'],
            'blog.index'
        );

        $routemanager->get(
            '/blog/{slug:[a-z\-]+}',
            [$this,'show'],
            'blog.show'
        );
    }

    public function index(ServerRequestInterface $request):string
    {

        return '<h1>Welcome to my blog</h1>';
    }
    public function show(ServerRequestInterface $request):string
    {
        $slug = $request->getAttribute('slug');
        return '<h1>Welcome to the post '. $slug .'</h1>';
    }
}
