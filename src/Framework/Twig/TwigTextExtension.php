<?php


namespace App\Framework\Twig;

/**
 * Making implementation for text
 * Class TwigTextExtension
 * @package App\Framework\Twig
 */
class TwigTextExtension extends \Twig_Extension
{
    /**
     * @return array TwigSimpleFilter
     */
    public function getFilters():array
    {
        return [
          new \Twig_SimpleFilter('extract', [$this, 'extract'])
        ];
    }

    /**
     * render an extract of content
     * @param string $content
     * @param int $maxLength
     * @return string
     */
    public function extract(string $content, int $maxLength = 150):string
    {


        if (mb_strlen($content) > $maxLength) {
            $extract = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($extract, ' ');
            $extract = mb_substr($extract, 0, $lastSpace).'...';
            return $extract;
        }

        return $content;
    }
}
