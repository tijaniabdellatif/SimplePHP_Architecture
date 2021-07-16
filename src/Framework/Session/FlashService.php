<?php


namespace App\Framework\Session;

/**
 * Class to handle flash messages
 * Class FlashService
 * @package App\Framework\Session
 */
class FlashService
{
    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @var string
     */
    private string $sessionKey = 'flash';

    /**
     * @var default null
     */
    private $messages;
    /**
     * FlashService constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Success session when editing
     * @param string $message
     */
    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    /**
     * info session when creating
     * @param string $message
     */
    public function info(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['info'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    /**
     * warning session when deleting
     * @param string $message
     */
    public function delete(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['delete'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function error(string $message)
    {

        $flash = $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function get(string $type):?string
    {
        if (is_null($this->messages)) {
            $this->messages = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }

        if (array_key_exists($type, $this->messages)) {
            return $this->messages[$type];
        }

        return null;
    }
}
