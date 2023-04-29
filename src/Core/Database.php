<?php

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private string $HOST;
    private string $DB_NAME;
    private string $USER;
    private string $PASS;

    private $dbh;
    private $error;
    private $queryError;

    private $stmt;

    public function __construct()
    {
        $this->HOST = Config::config('database.host');
        $this->DB_NAME = Config::config('database.db_name');
        $this->USER = Config::config('database.user');
        $this->PASS = Config::config('database.password');

        //dsn for mysql
        $dsn = "mysql:host=" . $this->HOST . ";dbname=" . $this->DB_NAME;
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->USER, $this->PASS, $options);
        }
        //catch any errors
        catch (PDOException $e) {
            Config::isDev() && throw $e;
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
        return $this;
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);

        return $this;
    }

    public function execute()
    {
        $this->stmt->execute();

        $this->queryError = $this->dbh->errorInfo();
        if (!is_null($this->queryError[2])) {
            echo $this->queryError[2];
        }

        return $this;
    }

    public function get()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    public function queryError()
    {
        $this->queryError = $this->dbh->errorInfo();
        if (!is_null($this->queryError[2])) {
            echo $this->queryError[2];
        }
    }
}
