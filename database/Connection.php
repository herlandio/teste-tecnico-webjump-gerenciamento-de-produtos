<?php

namespace Database;

use Config\Config;
use PDO;

class Connection {

    private $conn;

    /**
     * Start connection
     */

    public function initDatabase() {
        
        $host   = Config::getDbHost();
        $port   = Config::getDbPort();
        $db     = Config::getDbDatabase();

        $this->conn = new PDO(
            "mysql:host={$host}; port=$port; dbname={$db}",
            Config::getDbUser(), Config::getDbPassword(),
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );
        
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Receive connection
     * @return mixed
     */

    public function getConn() {
        return $this->conn;
    }

    /**
     * Release connection
     * @return null
     */

    public function libertyConection() {
        return $this->conn = null;
    }
}
