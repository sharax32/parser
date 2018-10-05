<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.10.2018
 * Time: 0:31
 */

namespace Models;

use Services\Database;

class ZodiacYear extends Model
{
    protected static $table = 'zodiac_year';
    protected static $fields = [
        'zodiac_id',
        'year',
        'work',
        'love',
        'money'
    ];

    public static function getZodiacYearByZodiac($zodiacId)
    {
        $query = Database::getInstance()->connect()->prepare('SELECT * FROM ' . static::$table . ' WHERE zodiac_id = :zodiac_id');
        $query->bindValue(":zodiac_id", $zodiacId);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public function updateYear()
    {
        $zodiac_id=$this->attributes['zodiac_id'];
        $year=$this->attributes['year'];
        $work=$this->attributes['work'];
        $love=$this->attributes['love'];
        $money=$this->attributes['money'];
        $query = Database::getInstance()->connect()->prepare('UPDATE ' . static::$table . ' SET year = :year, work = :work, love = :love, money = :money WHERE zodiac_id = :zodiac_id ');
        $query->bindValue(":zodiac_id", $zodiac_id);
        $query->bindValue(":year", $year);
        $query->bindValue(":work", $work);
        $query->bindValue(":love", $love);
        $query->bindValue(":money", $money);

        $query->execute();
    }
}