<?php

declare(strict_types=1);

namespace Database;

use Config\Config;
use PDO;

/* The `class Connection` is a PHP class that handles database connections using PDO (PHP Data
Objects). It contains methods to initialize a database connection, get the connection object, and
release the connection. The `initDatabase` method initializes the database connection using the
configuration values provided by the `Config` class. The `getConn` method returns the PDO connection
object, and the `libertyConection` method releases the connection by setting it to null. */
class Connection {

    /* The line `private ;` in the PHP class `Connection` is declaring a private property ``
    within the class. This property is used to store the PDO connection object that is established
    when initializing the database connection using PDO in PHP. */
    private $conn;

    /**
     * The function initializes a database connection using PDO in PHP.
     */
    public function initDatabase(): void {
        
        $host   = Config::getHost();
        $port   = Config::getPort();
        $db     = Config::getDatabase();

        $this->conn = new PDO(
            "mysql:host={$host}; port=$port; dbname={$db}",
            Config::getUser(), Config::getPassword(),
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
        );
        
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * The function `getConn` returns the PDO connection object.
     *
     * @return PDO An instance of the PDO class is being returned.
     */
    public function getConn(): PDO {
        return $this->conn;
    }

    /**
     * The function `libertyConnection` in PHP returns a null value for the connection.
     *
     * @return null The function `libertyConnection()` is returning `null`.
     */
    public function libertyConection(): null {
        return $this->conn = null;
    }
}
