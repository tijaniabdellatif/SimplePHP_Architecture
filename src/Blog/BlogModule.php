<?php


namespace App\Blog;

use Framework\ManagerRouter;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{
    private $renderer;
    public function __construct(ManagerRouter $routemanager,RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog',__DIR__.'/views');
      $routemanager->get(
          '/blog',[$this,'index'],'blog.index'
      );

        $routemanager->get(
            '/blog/{slug:[a-z\-0-9]+}',[$this,'show'],'blog.show'
        );
    }

    public function index(ServerRequestInterface $request):string{

        /*return '<h1>Welcome to my blog</h1>';*/
        return $this->renderer->render('@blog/index');

    }
    public function show(ServerRequestInterface $request):string{
        /*$slug = $request->getAttribute('slug');
        return '<h1>Welcome to the post '. $slug .'</h1>';*/

        return $this->renderer->render('@blog/show',
            ['slug'=>$request->getAttribute('slug')]
        );

    }
}