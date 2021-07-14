<?php


namespace App\Framework\Session;

class PHPSession implements SessionInterface
{

    /**
     *  ensure that the session is started
     */
    private function sessionStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        $this->sessionStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->sessionStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function delete(string $key): void
    {
        $this->sessionStarted();
        unset($_SESSION[$key]);
    }
}
