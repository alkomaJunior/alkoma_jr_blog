<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class MessagesType extends Form
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
            'body'  => [
                $this->field($this->model, $proprieties[0]->getName(), "input", "Veuillez renseigner votre nom", "text", "Nom et Prénoms"),
                $this->field($this->model, $proprieties[1]->getName(), "input", "Veuillez renseigner votre adresse email", "text", "Adresse email"),
                $this->field($this->model, $proprieties[2]->getName(), "input", "Veuillez donner un titre à votre message", "text", "Sujet"),
                $this->field($this->model, $proprieties[3]->getName(), "!input", "Veuillez écrire votre message", "7", "Message"),

            ],
            'end'  => $this->end(),
        ];
    }
}