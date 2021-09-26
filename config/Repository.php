<?php


namespace app\config;


abstract class Repository extends Model
{
    abstract public function tableName (): string;
    abstract public function attributes (): array;

    // Determine the total number of an entity
    public function numberOfModels(){
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("SELECT COUNT(id) as numberTotal FROM $tableName");
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_NUM);
    }

    // select for pagination
    public function allPaginate($currentPage, $perPage){
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName ORDER BY datePublish DESC LIMIT ".(($currentPage-1)*$perPage).", $perPage");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Add new entity
    public function new(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        //print each attributes value by using fn to define $attr variable
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = Application::$app->db->prepare("INSERT INTO $tableName (".implode(',', $attributes).")
                                        VALUES (".implode(',', $params).")
        ");

        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
    }

    // Edit an existing entity
    public function edit($where){
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        //print each attributes = his value by using fn to define $attr variable
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);

        //separate with comma
        $sql1 = implode(", ", $params);

        //get the array keys
        $wh = array_keys($where);

        //print each array keys = their values by using fn to define $attr variable and separate with AND
        $sql2  = implode("AND", array_map(fn($attr) => "$attr = :$attr", $wh));

        $statement = Application::$app->db->prepare("UPDATE $tableName SET $sql1 WHERE $sql2");

        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
    }

    // To change isRead status in the database
    public function changeBoolStatus($where, $boolAttributes){
        $tableName = $this->tableName();

        //get the array keys
        $wh = array_keys($where);

        //get bool attributes
        $boolAtt = array_keys($boolAttributes);

        //print each array keys = their values by using fn to define $attr variable and separate with AND
        $sql  = implode("AND", array_map(fn($attr) => "$attr = :$attr", $wh));

        $boolSql = implode(", ", array_map(fn($boolAttr) => "$boolAttr = :$boolAttr", $boolAtt));

        $statement = Application::$app->db->prepare("UPDATE $tableName SET $boolSql WHERE $sql");

        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        foreach ($boolAttributes as $attribute => $value){
            $statement->bindValue(":$attribute", $value);
        }

        $statement->execute();
    }

    // Select all instances of an entity
    public function all()
    {
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    // Select all instances of an entity
    public function allSuscriber()
    {
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE role != 'ADMIN'");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function findOne($where){
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public function findByIdPaginate($where, $currentPage, $perPage){
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $sql ORDER BY datePublish DESC LIMIT ".(($currentPage-1)*$perPage).", $perPage");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function remove($where){
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->db->prepare("DELETE FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
    }
}