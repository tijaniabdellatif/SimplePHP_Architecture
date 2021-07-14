<?php


namespace App\Framework\Twig;

class TwigAssetExtension extends \Twig_Extension
{
    public function getFunctions():array
    {
        return [
            new \Twig_SimpleFunction('assets', [$this, 'assets'], ['is_safe'=>['html']])
        ];
    }


    public function assets(string $name):string
    {

        $root = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$name;
        return '<link rel="stylesheet" href="'.$root.'">';
    }
}
