<?php


namespace App\Framework\Twig;

use App\Framework\Session\SessionFlash;

class FlashExtension extends \Twig_Extension
{
    /**
     * @var SessionFlash
     */
    private SessionFlash $flashSession;

    /**
     * FlashExtension constructor.
     * @param SessionFlash $flashSession
     */
    public function __construct(SessionFlash $flashSession)
    {
        $this->flashSession = $flashSession;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('flash', [$this,'flash'])
        ];
    }

    /**
     * @param $type
     * @return string
     */
    public function flash($type):?string
    {
        return $this->flashSession->get($type);
    }
}
