<?php


namespace app\config;


/**
 * Class Session
 * @package app\config
 */
class Session
{
    public function __construct()
    {
        if (!session_id()) @session_start();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}