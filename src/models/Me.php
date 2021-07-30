<?php


namespace app\src\models;


class Me extends \app\config\Repository
{
    protected $id;
    protected $myName;
    protected $occupation;
    protected $address;
    protected $phoneNumber;
    protected $emailAddress;
    protected $facebookLink;
    protected $instagramLink;
    protected $linkedinLink;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMyName()
    {
        return $this->myName;
    }

    /**
     * @return mixed
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return mixed
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    /**
     * @return mixed
     */
    public function getInstagramLink()
    {
        return $this->instagramLink;
    }

    /**
     * @return mixed
     */
    public function getLinkedinLink()
    {
        return $this->linkedinLink;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $myName
     */
    public function setMyName($myName): void
    {
        $this->myName = $myName;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @param mixed $emailAddress
     */
    public function setEmailAddress($emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @param mixed $facebookLink
     */
    public function setFacebookLink($facebookLink): void
    {
        $this->facebookLink = $facebookLink;
    }

    /**
     * @param mixed $instagramLink
     */
    public function setInstagramLink($instagramLink): void
    {
        $this->instagramLink = $instagramLink;
    }

    /**
     * @param mixed $linkedinLink
     */
    public function setLinkedinLink($linkedinLink): void
    {
        $this->linkedinLink = $linkedinLink;
    }

    /**
     * @param mixed $occupation
     */
    public function setOccupation($occupation): void
    {
        $this->occupation = $occupation;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function rules(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[1]->getName() => [self::RULE_REQUIRED],
            $proprieties[2]->getName() => [self::RULE_REQUIRED],
            $proprieties[3]->getName() => [self::RULE_REQUIRED],
            $proprieties[4]->getName() => [self::RULE_REQUIRED],
            $proprieties[5]->getName() => [self::RULE_REQUIRED, self::RULE_EMAIL],
            $proprieties[6]->getName() => [self::RULE_REQUIRED],
            $proprieties[7]->getName() => [self::RULE_REQUIRED],
            $proprieties[8]->getName() => [self::RULE_REQUIRED],
        ];
    }

    public function tableName(): string
    {
        return "me";
    }

    public function attributes(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[1]->getName(),
            $proprieties[2]->getName(),
            $proprieties[3]->getName(),
            $proprieties[4]->getName(),
            $proprieties[5]->getName(),
            $proprieties[6]->getName(),
            $proprieties[7]->getName(),
            $proprieties[8]->getName(),
        ];
    }
}