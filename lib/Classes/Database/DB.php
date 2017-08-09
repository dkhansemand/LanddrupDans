<?php

namespace Database;
use \PDO;
use \Log;

class DB extends \PDO implements \Log\Log{

    protected $conn;

    public function logError($errCode, $errLogBy, $errMsg){
        $timestamp = date("d-m-Y H:i:s");
        $date = date("d-m-y");
        $logPath = _LOG_PATH_ . 'error_'.$date.'.log';
        $logEntry = '[' . $timestamp . '][' . $errCode . '][' . $errLogBy . '] - ' . $errMsg . PHP_EOL;

        if(file_exists($logPath)){
            ## Log for the current date exsist, add new log entry.
            file_put_contents($logPath, $logEntry, FILE_APPEND) or die("Not able to write log entry to file");
        }else{
            ## Log for the current date does not exsist, create it first. Then add new log entry
            if(fopen($logPath, 'w')){
                file_put_contents($logPath, $logEntry, FILE_APPEND) or die("Not able to write log entry to file");
            }else{
                echo 'Not able to create file // ' . $logPath . 'error_'.$date.'.log';
            } 
        }
    }

    /**
     * __contruct of parent class PDO, opens the connection to specified SQL server
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $db
     */
    public function __construct($host, $username, $password, $db){
        try{
            $pdoOptions = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            );
            $this->conn = parent::__construct("mysql:host=$host;dbname=$db;charset=utf8", $username, $password, $pdoOptions);
        }catch(\PDOException $err){
            self::logError($err->getCode(), 'System\PDO', $err->getMessage());
            //echo 'Error logged, check logfile!';
            exit;
        }
    }

    public function prepQuery($query){
        return $this->prepare($query);
    }

    public function close(){
        unset($this->conn);
    }

}
