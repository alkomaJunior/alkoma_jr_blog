<?php


namespace app\src\form;


use app\config\form\Form;
use app\config\Model;

class CommentsType extends Form
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
        parent::__construct($this->action, $this->method);
    }

    public function createForm(): array
    {
        $reflect = new \ReflectionClass($this->model);
        $proprieties = $reflect->getProperties();

        return [
            'begin'    =>    new Form($this->action, $this->method),
            'title'     =>    $this->field($this->model, $proprieties[1]->getName(), "input", "Veuillez titrer votre commentaire", "text", "Titre"),
            'comment'    =>    $this->field($this->model, $proprieties[2]->getName(), "!input", "Votre commenaire...", "6", "Commentaire"),
            'end'      =>    $this->end(),
        ];
    }

}