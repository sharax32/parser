<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 21:24
 */

namespace Services;

use Traits\Single;

class Database
{
    use Single;
    private $conn = null;
    private $config;
    public function __construct()
    {
        $this->config = require __DIR__ ."/../config/config.php";
    }
    public function connect(){
        if(is_null($this->conn)){
            try {
                $this->conn = new \PDO(
                    $this->prepareDsn(),
                    $this->config['db']['login'],
                    $this->config['db']['password']
                );
            }catch (\Exception $e){
                exit("Нет подключения к базе");
            }
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $this->conn;
    }
    private function prepareDsn()
    {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['db']['driver'],
            $this->config['db']['host'],
            $this->config['db']['database'],
            $this->config['db']['charset']
        );
    }
}