<?php

namespace app\src\form;

use app\config\form\Form;
use app\config\Model;

class PortfolioType extends Form
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
            'begin'             => new Form($this->action, $this->method),
            'title'             => $this->field($this->model, $proprieties[1]->getName(), "input", "Titre du portfolio", "text", "Titre"),
            'client'            => $this->field($this->model, $proprieties[2]->getName(), "input", "Client", "text", "Client"),
            'objective'         => $this->field($this->model, $proprieties[3]->getName(), "!input", "Objectif du projet", "4", "objectif"),
            'description'       => $this->field($this->model, $proprieties[4]->getName(), "!input", "Description du projet....", "8", "Description"),
            'end'               => $this->end(),
        ];
    }

}