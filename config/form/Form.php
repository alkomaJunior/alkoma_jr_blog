<?php


namespace app\config\form;

use app\config\Model;

/**
 * Class Form
 * @package app\core\form
 */
class Form
{
    protected string $action;
    protected string $method;

    public function __construct($action, $method){
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function end(): string
    {
        return '</form>';
    }

    public function field (Model $model, string $attribute, string $formType, string $placeholder, string $inputTypeOrRow, string $label): Field
    {
        return new Field($model, $attribute, $formType, $placeholder, $inputTypeOrRow, $label);
    }

    public function __toString(){
        return sprintf('
            <form class="needs-validation pt-4 pb-5" action="%s" method="%s">
        ',

        $this->action,
        $this->method,

        );
    }
}