<?php


namespace App\Framework\Twig;

use Framework\ManagerRouter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\SemanticUiView;
use Pagerfanta\View\TwitterBootstrap4View;

class TwigPagerExtension extends \Twig_Extension
{
    private $router;
    public function __construct(ManagerRouter $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
         return[

             new \Twig_SimpleFunction(
                 'paginate',
                 [$this,'paginate'],
                 ['is_safe'=>['html']]
             )

         ];
    }

    public function paginate(Pagerfanta $paginator, string $route, array $queryArgs = []):string
    {

           $view = new TwitterBootstrap4View();

           return  $view->render($paginator, function (int $page) use ($route, $queryArgs) {

            if ($page > 1) {
                $queryArgs['p'] = $page;
            }
             return $this->router->getGeneratedUri($route, [], $queryArgs);
           });
    }
}
