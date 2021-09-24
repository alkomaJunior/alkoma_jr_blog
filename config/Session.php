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
        $session = filter_var_array($_SESSION);
        $session[$key] = $value;
    }

    public function get($key)
    {
        $session = filter_var_array($_SESSION);
        return $session[$key] ?? false;
    }

    public function remove($key)
    {
        $session = filter_var_array($_SESSION);
        unset($session[$key]);
    }
}