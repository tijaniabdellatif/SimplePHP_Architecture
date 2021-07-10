<?php


namespace App\Framework\Router;



use Framework\ManagerRouter;

class RouterTwigExtension extends \Twig_Extension
{

    private $manager;
    public function __construct(ManagerRouter $manager){


        $this->manager=$manager;

    }

    public function getFunctions()
    {
        return [

            new \Twig_SimpleFunction('path',[$this,'pathFor'])
        ];
    }


    public function pathFor(string $path,array $params=[]):string{


          return $this->manager->getGeneratedUri($path,$params);
    }


}