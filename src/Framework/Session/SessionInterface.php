<?php


namespace App\Framework\Session;

interface SessionInterface
{

    /**
     * Get the session information
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Add information to the session
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value):void;

    /**
     * Delete a session key
     * @param string $key
     * @return void
     */
    public function delete(string $key):void;
}
