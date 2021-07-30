<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class MeType extends Form
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
            'begin'       => new Form($this->action, $this->method),
            'name'        => $this->field($this->model, $proprieties[1]->getName(), "input", "Mon nom", "text", "Titre"),
            'occupation'  => $this->field($this->model, $proprieties[2]->getName(), "input", "Ma profession", "text", "Profession"),
            'address'     => $this->field($this->model, $proprieties[3]->getName(), "input", "Mon adresse", "text", "Adresse"),
            'phone'       => $this->field($this->model, $proprieties[4]->getName(), "input", "Mon téléphone", "text", "Téléphone"),
            'email'       => $this->field($this->model, $proprieties[5]->getName(), "input", "Mon email", "text", "Email"),
            'fbkLink'     => $this->field($this->model, $proprieties[6]->getName(), "input", "Mon lien facebook", "text", "Facebook"),
            'iLink'       => $this->field($this->model, $proprieties[7]->getName(), "input", "Mon lien instagram", "text", "Instagram"),
            'lLink'       => $this->field($this->model, $proprieties[8]->getName(), "input", "Mon lien linkedin", "text", "Linkedin"),
            'end'         => $this->end(),
        ];
    }
}