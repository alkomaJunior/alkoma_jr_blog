<?php


namespace app\core\form;

use app\core\Model;

/**
 * Class Form
 * @package app\core\form
 */
class Form
{
    public static function begin($action, $method): Form
    {
        echo "<form action=\"{$action}\" method=\"{$method}\">";
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field (Model $model, $attribute): Field
    {
        return new Field($model, $attribute);
    }
}