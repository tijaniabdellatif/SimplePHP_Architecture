<?php


namespace App\Framework\Session;

class ArraySession implements SessionInterface
{
    /**
     * @var SessionInterface
     */
    private $session = [];

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {

        if (array_key_exists($key, $_SESSION)) {
            return $this->session[$key];
        }
        return $default;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {

        $this->session[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function delete(string $key): void
    {

        unset($this->session[$key]);
    }
}
