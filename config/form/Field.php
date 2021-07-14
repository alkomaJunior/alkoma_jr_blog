<?php


namespace app\core\form;

use app\core\Model;

/**
 * Class Field
 * @package app\core\form
 */
class Field
{
    public Model $model;
    public string $attribute;

    public function __construct (Model $model, string $attribute){
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString(){
        return 'the template with sprintf';
    }
}