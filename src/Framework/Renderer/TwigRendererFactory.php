<?php


namespace Framework\Renderer;
use Psr\Container\ContainerInterface;

class TwigRendererFactory
{

    public function __invoke(ContainerInterface $container) : TwigRenderer{

        $viewPath = $container->get('views.path');
        $loader = new \Twig_Loader_Filesystem($viewPath);
        $twig = new \Twig_Environment($loader);

        $extensions = $container->get('twig.extensions');
        if($container->has('twig.extensions'))
        {
            foreach ($extensions as $extension){

                $twig->addExtension($extension);
            }
        }
        return new TwigRenderer($loader,$twig);

    }

}