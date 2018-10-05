<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 21:52
 */

namespace Models;

use Services\Database;

class Model
{
    protected static $table;
    protected static $fields = [];
    protected $attributes = [];

    /**
     * Model constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if (empty(static::$table)) {
            throw new \Exception('Не определили таблицу в:' . get_class($this));
        }
        if(empty(static::$fields)) {
            throw new \Exception('Не определили поля таблицы в:' . get_class($this));
        }
    }

    public function prepareAttributes(array $data)
    {
        foreach ($data as $key => $val){
            if(in_array($key, static::$fields)){
                $this->attributes[$key] = $val;
            }
        }
    }

    protected function bindParams(\PDOStatement $query)
    {
        foreach ($this->attributes as $key => $value){
            $query->bindValue(":$key", $value);
        }
        return $query;
    }

    protected function insert()
    {
        $columns = array_keys($this->attributes);
        if(!empty($this->attributes)){
            $query = Database::getInstance()->connect()->prepare('INSERT INTO ' . static::$table . '(' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns).')');
            $query = $this->bindParams($query);
            $query->execute();
        }
    }


    public function save()
    {
        $this->insert();
    }
}