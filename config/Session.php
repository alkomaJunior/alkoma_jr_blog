<?php


namespace app\config;


/**
 * Class Session
 * @package app\config
 */
class Session
{
    private $session;

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session): void
    {
        $this->session = $session;
    }

    public function __construct()
    {
        if (!session_id()) @session_start();
       $this->session = &$_SESSION;
    }

    public function set($key, $value)
    {
        $this->session[$key] = $value;
    }

    public function get($key)
    {
        return $this->session[$key] ?? false;
    }

    public function remove($key)
    {
        unset($this->session[$key]);
    }
}