<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class UsersType extends Form
{
    public Model $model;

    public function __construct(Model $model, string $action, string $method)
    {
        $this->model = $model;
        $this->method = $method;
        $this->action = $action;
        parent::__construct($action, $method);
    }

    public function createForm(): array
    {

        $reflect = new \ReflectionClass($this->model);
        $proprieties = $reflect->getProperties();

        return [
            'begin'     => new Form($this->action, $this->method),
            'firstName' => $this->field($this->model, $proprieties[1]->getName(), "input", "Ex : Abdel", "text", "Prénoms"),
            'lastName'  => $this->field($this->model, $proprieties[2]->getName(), "input", "Ex : ATOKOU", "text", "Nom"),
            'email'     => $this->field($this->model, $proprieties[3]->getName(), "input", "a.atokou@gmail.com", "email", "Adresse email"),
            'phone'     => $this->field($this->model, $proprieties[4]->getName(), "input", "+22899775588", "text", "Numéro de téléphone"),
            'pass'      => $this->field($this->model, $proprieties[5]->getName(), "input", "*****", "password", "Mot de passe"),
            'confPass'  => $this->field($this->model, $proprieties[6]->getName(), "input", "*****", "password", "Confirmez votre mot de passe"),
            'end'       => $this->end(),
        ];
    }

}