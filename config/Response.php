<?php


namespace app\config;

/**
 * Class Response
 * @package app\config
 */
class Response
{
    public function setStatusCode(int $code){
        http_response_code($code);
    }
}