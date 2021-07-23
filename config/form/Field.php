<?php


namespace app\config\form;

use app\config\Model;

/**
 * Class Field
 * @package app\core\form
 */
class Field
{
    public Model $model;
    public string $attribute;
    public string $formType;
    public string $inputTypeOrRow;
    public string $placeholder;
    public string $label;

    public function __construct (Model $model, string $attribute, string $formType, string $placeholder, string $inputTypeOrRow, $label){
        $this->model = $model;
        $this->attribute = $attribute;
        $this->formType = $formType;
        $this->inputTypeOrRow = $inputTypeOrRow;
        $this->placeholder = $placeholder;
        $this->label = $label;
    }

    public function __toString(){
        if ($this->formType === "input"){
            return sprintf('
                <label for="%s">%s<span class="text-danger font-weight-medium">*</span></label>
                <input class="form-control %s" value="%s" name="%s" type="%s" id="%s" placeholder="%s">
                <div class="invalid-feedback">%s</div>
        ',

                $this->attribute,
                $this->label,
                $this->model->hasError($this->attribute) ? ' is-invalid' : '',
                method_exists($this->model, 'get'.ucfirst($this->attribute)) ? call_user_func([$this->model, 'get'.ucfirst($this->attribute)]) : '',
                $this->attribute,
                $this->inputTypeOrRow,
                $this->attribute,
                $this->placeholder,
                $this->model->getFirstError($this->attribute),

            );
        }
        else{
            return sprintf('
                <label for="%s">%s<span class="text-danger font-weight-medium">*</span></label>
                <textarea class="form-control %s" rows="%s" name="%s" id="%s" placeholder="%s">%s</textarea>
                <div class="invalid-feedback">%s</div>
            
            ',

                $this->attribute,
                $this->label,
                $this->model->hasError($this->attribute) ? ' is-invalid' : '',
                $this->inputTypeOrRow,
                $this->attribute,
                $this->attribute,
                $this->placeholder,
                method_exists($this->model, 'get'.ucfirst($this->attribute)) ? call_user_func([$this->model, 'get'.ucfirst($this->attribute)]) : 'no',
                $this->model->getFirstError($this->attribute),

            );
        }

    }
}