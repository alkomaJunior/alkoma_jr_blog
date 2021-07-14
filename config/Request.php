<?php

namespace app\config;

/**
 * Class Request
 * @package app\config
 */
class Request
{

    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false){
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet($method): bool
    {
        if ($method === 'get'){
            return true;
        }
        else{
            return false;
        }
    }

    public function isPost($method): bool
    {
        if ($method === 'post'){
            return true;
        }
        else{
            return false;
        }
    }

    public function getRequestData(): array
    {
        $requestData = [];

        if ($this->isGet($this->getMethod())){
            foreach ($_GET as $key => $value){
                $requestData[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost($this->getMethod())){
            foreach ($_POST as $key => $value){
                $requestData[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $requestData;
    }
}