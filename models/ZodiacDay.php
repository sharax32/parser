<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.10.2018
 * Time: 0:31
 */

namespace Models;

use Services\Database;

class ZodiacDay extends Model
{
    protected static $table = 'zodiac_day';
    protected static $fields = [
        'zodiac_id',
        'day',
        'value'
    ];


    public static function getZodiacDayByZodiac($zodiacId)
    {
        $query = Database::getInstance()->connect()->prepare('SELECT * FROM ' . static::$table . ' WHERE zodiac_id = :zodiac_id');
        $query->bindValue(":zodiac_id", $zodiacId);
        $query->execute();
        return $query->fetchAll();
    }
    public function updateDay()
    {
        $zodiac_id=$this->attributes['zodiac_id'];
        $day=$this->attributes['day'];
        $value=$this->attributes['value'];
        $query = Database::getInstance()->connect()->prepare('UPDATE ' . static::$table . ' SET value = :value'.' WHERE zodiac_id = :zodiac_id AND day = :day');
        $query->bindValue(":zodiac_id", $zodiac_id);
        $query->bindValue(":day", $day);
        $query->bindValue(":value", $value);
        $query->execute();

    }
    public static  function delDays($zodiac_id)
    {
        $query = Database::getInstance()->connect()->prepare('DELETE FROM '. static::$table.' WHERE zodiac_id = :zodiac_id');
        $query->bindValue(":zodiac_id", $zodiac_id);
        $query->execute();
    }


}