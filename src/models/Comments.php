<?php


namespace app\src\models;


use app\config\Repository;

class Comments extends Repository
{

    protected $id;
    protected $title;
    protected $comment;
    protected int $idUsers;
    protected int $idPosts;
    protected Users $users;
    protected Posts $posts;
    protected $datePublish;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
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
    public function getDatePublish()
    {
        return $this->datePublish;
    }

    /**
     * @param Users $users
     */
    public function setUsers(Users $users): void
    {
        $this->users = $users;
    }

    /**
     * @return int
     */
    public function getIdPosts(): int
    {
        return $this->idPosts;
    }

    /**
     * @param int $idPosts
     */
    public function setIdPosts(int $idPosts): void
    {
        $this->idPosts = $idPosts;
    }

    /**
     * @return int
     */
    public function getIdUsers(): int
    {
        return $this->idUsers;
    }

    /**
     * @param int $idUsers
     */
    public function setIdUsers(int $idUsers): void
    {
        $this->idUsers = $idUsers;
    }

    public function rules(): array
    {
        $reflect = new \ReflectionClass($this);
        $proprieties = $reflect->getProperties();

        return [
            $proprieties[1]->getName() => [self::RULE_REQUIRED],
            $proprieties[2]->getName() => [self::RULE_REQUIRED],
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
            $proprieties[4]->getName(),
        ];
    }
}