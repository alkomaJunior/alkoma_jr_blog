<?php


namespace app\src\models;


use app\config\Repository;

class Comments extends Repository
{

    protected $id;
    protected $comment;
    protected Users $users;
    protected Posts $posts;

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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return Posts
     */
    public function getPosts(): Posts
    {
        return $this->posts;
    }

    /**
     * @return Users
     */
    public function getUsers(): Users
    {
        return $this->users;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @param Posts $posts
     */
    public function setPosts(Posts $posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @param Users $users
     */
    public function setUsers(Users $users): void
    {
        $this->users = $users;
    }

    public function rules(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[1]->getName() => [self::RULE_REQUIRED],
        ];
    }

    public function tableName(): string
    {
        return "comments";
    }

    public function attributes(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[1]->getName(),
            $proprieties[2]->getName(),
            $proprieties[3]->getName(),
        ];
    }
}