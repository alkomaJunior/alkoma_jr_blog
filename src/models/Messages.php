<?php


namespace app\src\models;


use app\config\Model;

class Messages extends Model
{
    protected $name;
    protected $emailAddress;
    protected $subject;
    protected $message;

    public function rules(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[0]->getName() => [self::RULE_REQUIRED],
            $proprieties[1]->getName() => [self::RULE_REQUIRED, self::RULE_EMAIL],
            $proprieties[2]->getName() => [self::RULE_REQUIRED],
            $proprieties[3]->getName() => [self::RULE_REQUIRED],
        ];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param mixed $emailAdress
     */
    public function setEmailAddress($emailAdress): void
    {
        $this->emailAddress = $emailAdress;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

}