<?php


namespace App\Admin;

use Framework\Module;
use Framework\Renderer\RendererInterface;

class AdminModule extends Module
{

    const __DEFINITIONS__ = __DIR__.'/config.php';
    public function __construct(RendererInterface $renderer)
    {

        $renderer->addPath('admin', __DIR__.'/views');
    }
}
