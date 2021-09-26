<?php


namespace app\config;

/**
 * Class Model
 * @package app\core
 */
abstract class Model
{
    public array $errors = [];

    abstract public function rules(): array;

    // Different validation rules
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    // Loading data into classes
    public function loadData($data){
        foreach ($data as $key => $value){
            if (property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    // Check of validation rules
    public function isValid(): bool
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && (!$value || $value === " ")) {
                    $this->addErrorForRules($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRules($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRules($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRules($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRules($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRules($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    // Error with attribute
    private function addErrorForRules(string $attribute, string $rule, $params = []){
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    // Simple string error
    public function addError(string $attribute, string $message){
        $this->errors[$attribute][] = $message;
    }

    // Error messages definition
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Ce champ est obligatoire',
            self::RULE_EMAIL => 'Ceci n\'est pas une adresse email valide',
            self::RULE_MIN => 'Ce champ doit contenir au moins {min} caractère',
            self::RULE_MAX => 'Ce champ doit contenir au plus {max} caractère',
            self::RULE_MATCH => 'Les deux champs ne sont pas équivalent',
            self::RULE_UNIQUE => 'Un enregistrement avec cette valeur exite déjà',
        ];
    }

    // Test if there is an error
    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }

    // Get first error from an array of more than one error
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}