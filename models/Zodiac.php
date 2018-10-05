<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 22:17
 */

namespace Models;


use Services\Database;

class Zodiac extends Model
{
    protected static $table = 'zodiac';
    protected static $fields = [
        'id',
        'name',
        'link'

    ];
    protected $primaryKey = 'id';

    public static function getAllZodiac()
    {
        return Database::getInstance()->connect()->query('SELECT * FROM ' . static::$table )->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}