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
            $position = strpos($path, '?');
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

        $dataGet = filter_input_array(INPUT_GET);
        $dataPost = filter_input_array(INPUT_POST);

        if (isset($dataGet) && $this->isGet($this->getMethod())){
            foreach ($dataGet as $key => $value){
                $requestData[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if (isset($dataPost) && $this->isPost($this->getMethod())){
            foreach ($dataPost as $key => $value){
                $requestData[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $requestData;
    }
}