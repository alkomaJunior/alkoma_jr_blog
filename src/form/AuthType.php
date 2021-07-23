<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class AuthType extends Form
{
    public Model $model;

    /**
     * MessagesType constructor.
     * @param Model $model
     * @param string $action
     * @param string $method
     */
    public function __construct(Model $model, string $action, string $method)
    {
        $this->model = $model;
        $this->method = $method;
        $this->action = $action;
        return parent::__construct($this->action, $this->method);
    }

    public function buildForm(): array
    {
        $reflect = new \ReflectionClass($this->model);
        $proprieties = $reflect->getProperties();

        return [
            'body' => [
                $this->field($this->model, $proprieties[0]->getName(), "input", "a.atokou@gmail.com", "email", "Adresse email"),
                $this->field($this->model, $proprieties[1]->getName(), "input", "*****", "password", "Mot de passe"),

            ],
            'end' => $this->end(),
        ];
    }
}