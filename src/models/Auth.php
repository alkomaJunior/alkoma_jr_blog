<?php


namespace app\src\models;


use app\config\Model;

class Auth extends Model
{
    protected $emailC;
    protected $passwordC;

    /**
     * @return mixed
     */
    public function getEmailC()
    {
        return $this->emailC;
    }

    /**
     * @param mixed $emailC
     */
    public function setEmailC($emailC): void
    {
        $this->emailC = $emailC;
    }

    /**
     * @return mixed
     */
    public function getPasswordC()
    {
        return $this->passwordC;
    }

    /**
     * @param mixed $passwordC
     */
    public function setPasswordC($passwordC): void
    {
        $this->passwordC = $passwordC;
    }



    public function rules(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[0]->getName() => [self::RULE_REQUIRED],
            $proprieties[1]->getName() => [self::RULE_REQUIRED],
        ];
    }
}