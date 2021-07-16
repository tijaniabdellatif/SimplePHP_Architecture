<?php


namespace App\Framework\Session;

/**
 * Class ArraySession
 * @package App\Framework\Session
 */
class ArraySession implements SessionInterface
{
    /**
  moi   * @var array
     */
    private $session = [];

    /**
     * Récupère une information en Session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {

        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        }
        return $default;
    }

    /**
     * Ajoute une information en Session
     *
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value): void
    {

        $this->session[$key] = $value;
    }

    /**
     * Supprime une clef en session
     * @param string $key
     */
    public function delete(string $key): void
    {

        unset($this->session[$key]);
    }
}
