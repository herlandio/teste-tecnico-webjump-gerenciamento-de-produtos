<?php

namespace Database;

use Config\Config;
use PDO;

class Connection {

    private $host         = Config::DBHOST;
    private $user         = Config::DBUSER;
    private $pass         = Config::DBPASSWORD;
    private $db           = Config::DBDATABASE;
    private $port         = Config::DBPORT;

    private $conn;

    /**
     * Start connection
     */

    public function initDatabase() {
        $this->conn = new PDO("mysql:host={$this->host}; port={$this->port}; dbname={$this->db}", $this->user, $this->pass, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ));
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