<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class UsersType extends Form
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
                $this->field($this->model, $proprieties[0]->getName(), "input", "Ex : Abdel", "text", "Prénoms"),
                $this->field($this->model, $proprieties[1]->getName(), "input", "Ex : ATOKOU", "text", "Nom"),
                $this->field($this->model, $proprieties[2]->getName(), "input", "a.atokou@gmail.com", "email", "Adresse email"),
                $this->field($this->model, $proprieties[3]->getName(), "input", "+22899775588", "text", "Numéro de téléphone"),
                $this->field($this->model, $proprieties[4]->getName(), "input", "*****", "password", "Mot de passe"),
                $this->field($this->model, $proprieties[5]->getName(), "input", "*****", "password", "Confirmez votre mot de passe"),

            ],
            'end'  => $this->end(),
        ];
    }

}