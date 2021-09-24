<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class PostsType extends Form
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
            'begin'         => new Form($this->action, $this->method),
            'caption'       => $this->field($this->model, $proprieties[4]->getName(), "!input", "Chapô", "4", "Chapô"),
            'title'         => $this->field($this->model, $proprieties[1]->getName(), "input", "Titre du post", "text", "Titre"),
            'description'   => $this->field($this->model, $proprieties[2]->getName(), "!input", "Description du post....", "8", "Description"),
            'end'           => $this->end(),
        ];
    }

}