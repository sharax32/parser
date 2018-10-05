<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.10.2018
 * Time: 0:04
 */

namespace Models;

use Services\Database;

class ZodiacMonth extends Model
{
    protected static $table = 'zodiac_month';
    protected static $fields = [
        'zodiac_id',
        'month',
        'work',
        'love',
        'money'
    ];

    public static function getZodiacMonthByZodiac($zodiacId)
    {
        $query = Database::getInstance()->connect()->prepare('SELECT * FROM ' . static::$table . ' WHERE zodiac_id = :zodiac_id');
        $query->bindValue(":zodiac_id", $zodiacId);
        $query->execute();
        return $query->fetch();
    }

    public function updateMonth()
    {
        $zodiac_id=$this->attributes['zodiac_id'];
        $month=$this->attributes['month'];
        $work=$this->attributes['work'];
        $love=$this->attributes['love'];
        $money=$this->attributes['money'];
        $query = Database::getInstance()->connect()->prepare('UPDATE ' . static::$table . ' SET month = :month, work = :work, love = :love, money = :money WHERE zodiac_id = :zodiac_id ');
        $query->bindValue(":zodiac_id", $zodiac_id);
        $query->bindValue(":month", $month);
        $query->bindValue(":work", $work);
        $query->bindValue(":love", $love);
        $query->bindValue(":money", $money);
        $query->execute();

    }
}
