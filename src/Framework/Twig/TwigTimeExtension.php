<?php


namespace App\Framework\Twig;

class TwigTimeExtension extends \Twig_Extension
{

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters():array
    {
        return [

        new \Twig_SimpleFilter('ago', [$this,'ago'], ['is_safe'=>['html']])
        ];
    }

    public function ago(\DateTime $date, string $format = 'd/m/Y H:i')
    {


        return '<time class="timeago" style="padding:12px" datetime="'.$date->format(\DateTime::ISO8601).'">'.
         $date->format($format)
         .'</time>';
    }
}
