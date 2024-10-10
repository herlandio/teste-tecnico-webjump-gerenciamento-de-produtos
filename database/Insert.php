<?php

declare(strict_types=1);

namespace Database;

use PDOException;

/* The `Insert` class in PHP handles database insertions with PDO, utilizing a `Connection` object for
database connections and implementing exception handling with a rollback mechanism. */
class Insert {

    /* The line `private Connection ;` is declaring a private property `` of type
    `Connection` within the `Insert` class in PHP. This property is used to store an instance of the
    `Connection` class, which is responsible for establishing a connection to the database. By
    declaring it as a private property, it can be accessed and utilized within the `Insert` class
    methods for performing database operations. */
    private Connection $connection;

    /* The line `private ?string ;` in the provided PHP code is declaring a private property
    `` within the `Insert` class. */
    private ?string $lastID;

    /**
     * The above function is a PHP constructor that initializes a new Connection object.
     */
    public function __construct() {
        $this->connection = new Connection();
    }
    
    /**
     * The function `insert` inserts data into a specified table using prepared statements in PHP,
     * handling transactions and error handling.
     *
     * @param string table The `table` parameter in the `insert` function represents the name of the
     * database table where you want to insert the data. It is a string that should contain the name of
     * the table in which you want to perform the insertion operation.
     * @param array data The `insert` function you provided is used to insert data into a database
     * table. The `` parameter is an associative array where the keys represent the column names
     * in the table and the values represent the data to be inserted into those columns.
     */
    public function insert(string $table, array $data): void {

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
    
        $this->connection->getConn()->beginTransaction();
    
        try {
            $statement = $this->connection->getConn()->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
            $statement->execute(array_values($data));
            $this->lastID = $this->connection->getConn()->lastInsertId();
            $this->connection->getConn()->commit();
    
        } catch (PDOException $e) {

            $this->connection->getConn()->rollBack();
    
            echo json_encode([
                "File" => $e->getFile(),
                "Line" => $e->getLine(),
                "Message" => $e->getMessage(),
                "CodeError" => $e->getCode()
            ]);
    
        } finally {
            $this->connection->libertyConnection();
        }
    }

    /**
     * The function lastId() returns the last ID as a nullable string in PHP.
     *
     * @return ?string The function `lastId()` is returning the value of the property ``, which
     * is a string or null.
     */
    public function lastId(): ?string {
        return $this->lastID;
    }
}
