<?php


namespace Test\Framework\Session;

use App\Framework\Session\ArraySession;
use App\Framework\Session\FlashService;
use PHPUnit\Framework\TestCase;

class FlashServiceTest extends TestCase
{
    /**
     * @var ArraySession
     */
    private ArraySession $session;
    /**
     * @var FlashService
     */
    private FlashService $flashService;

    public function setUp(): void
    {
        $this->session = new ArraySession();
        $this->flashService = new FlashService($this->session);
    }

    public function testDeleteFlash()
    {
        $this->flashService->success('bravo');
        $this->assertEquals('bravo', $this->flashService->get('success'));
        $this->assertNull($this->session->get('flash'));
        $this->assertEquals('bravo', $this->flashService->get('success'));
        $this->assertEquals('bravo', $this->flashService->get('success'));
    }
}
