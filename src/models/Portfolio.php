<?php

namespace app\src\models;

use app\config\Repository;

class Portfolio extends Repository
{
    protected $id;
    protected $title;
    protected $client;
    protected $objective;
    protected $description;
    protected $datePublish;
    protected $image;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @param mixed $objective
     */
    public function setObjective($objective): void
    {
        $this->objective = $objective;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $datePublish
     */
    public function setDatePublish($datePublish): void
    {
        $this->datePublish = $datePublish;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return mixed
     */
    public function getObjective()
    {
        return $this->objective;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDatePublish()
    {
        return $this->datePublish;
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
        ];
    }

    public function tableName(): string
    {
        return 'portfolio';
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
            $proprieties[6]->getName(),
        ];
    }
}