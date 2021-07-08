<?php


namespace Test\Framework;


use Framework\ManagerRenderer;

class RendererTest extends \PHPUnit\Framework\TestCase
{
    private $renderermanager;

    public function setUp(): void
    {
              $this->renderermanager = new ManagerRenderer();
    }

    public function testRenderRightPath(){

           $this->renderermanager->addPath('blog',__DIR__.'/views');
           $content = $this->renderermanager->render('@blog/demo');
           $this->assertEquals('hi everybody !',$content);

    }

    public function testRendererDefaultPath()
    {
        $this->renderermanager->addPath(__DIR__.'/views');
        $content = $this->renderermanager->render('demo');
        $this->assertEquals('hi everybody !',$content);

    }
}