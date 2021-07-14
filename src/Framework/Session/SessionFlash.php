<?php


namespace App\Framework\Session;

/**
 * Service for handling the session appereance
 * Class SessionFlash
 * @package App\Framework\Session
 */
class SessionFlash
{
    /**
     * @var SessionInterface
     */
    private SessionInterface $session;

    private string $sessionKey = 'flash';

    /**
     * @var
     */
    private $message;

    /**
     * SessionFlash constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $message
     */
    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function error(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function info(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['info'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function onDelete(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['delete'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }



    /**
     * @param string $type
     * @return string|null
     */
    public function get(string $type):?string
    {
        if (is_null($this->message)) {
            $this->message = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }


        if (array_key_exists($type, $this->message)) {
            return $this->message[$type];
        }

        return null;
    }
}
