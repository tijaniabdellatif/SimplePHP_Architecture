<?php


namespace App\Framework\Twig;

use App\Framework\Session\FlashService;
use Twig_SimpleFunction;

class TwigFlashExtension extends \Twig_Extension
{
    /**
     * @var FlashService
     */

    private FlashService $flashService;

    /**
     * TwigFlashExtension constructor.
     * @param FlashService $flashService
     */
    public function __construct(FlashService $flashService)
    {
        $this->flashService=$flashService;
    }

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [
              new Twig_SimpleFunction('flash', [$this,'flash'])
        ];
    }

    /**
     * @param $type
     */
    public function flash($type): ?string
    {
        return $this->flashService->get($type);
    }
}
