<?php


namespace app\config;


abstract class Repository extends Model
{
    abstract public function tableName (): string;
    abstract public function attributes (): array;

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

    public function all(): array
    {
        $tableName = $this->tableName();
        $statement = Application::$app->db->prepare("SELECT * FROM $tableName");
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