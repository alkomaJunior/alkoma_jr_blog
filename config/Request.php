<?php

namespace app\config;

/**
 * Class Request
 * @package app\config
 */
class Request
{

    public function getPath(){
        $path = filter_input(INPUT_SERVER, 'REQUEST_URI') ?? '/';
        if (isset($path)){
            $position = strpos(stripslashes($path), '?');
            if ($position === false){
                return $path;
            }
            return substr($path, 0, $position);
        }
    }

    public function getMethod(): string
    {
        $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

        if (isset($requestMethod)) return strtolower($requestMethod);

        return '';
    }

    public function isGet($method): bool
    {
        if ($method === 'get') return true;

        return false;
    }

    public function isPost($method): bool
    {
        if ($method === 'post') return true;

        return false;
    }

    public function getRequestData(): array
    {
        $requestData = [];

        $dataGetType [] = filter_input(INPUT_GET, '');
        $dataPostType [] = filter_input(INPUT_POST, '');

        if (isset($dataGetType) && $this->isGet($this->getMethod())){
            foreach ($dataGetType as $key => $value){
                $requestData[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if (isset($_POST) && $this->isPost($this->getMethod())){
            foreach ($_POST as $key => $value){
                $requestData[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }



        return $requestData;
    }
}