<?php

declare(strict_types=1);

namespace Database;

use PDOException;

/* The `Delete` class in PHP contains a method to delete records from a specified table using a
database connection managed by a `Connection` object. */
class Delete {

    /* The line `private Connection ;` in the PHP code snippet is declaring a private
    property named `` of type `Connection`. This property is an instance of the
    `Connection` class, which is used to establish a database connection within the `Delete` class.
    This property is initialized in the constructor of the `Delete` class by creating a new
    `Connection` object. */
    private Connection $connection;

    /**
     * The above function is a PHP constructor that initializes a new Connection object.
     */
    public function __construct() {
        $this->connection = new Connection();
    }

    /**
     * The function `delete` in PHP deletes records from a specified table with an optional WHERE
     * clause, handling transactions and error reporting.
     *
     * @param string table The `table` parameter in the `delete` function represents the name of the
     * table from which you want to delete records. It is a required parameter and should be a string
     * value specifying the table name. For example, if you want to delete records from a table named
     * 'users', you would pass
     * @param ?string where The `where` parameter in the `delete` function is used to specify the condition for
     * deleting records from the database table. It allows you to pass a custom WHERE clause to filter
     * the rows that should be deleted.
     */
    public function delete(string $table, ?string $where = '') {

        if (empty($where)) {
            throw new \InvalidArgumentException("A cláusula WHERE é obrigatória para deletar registros.");
        }

        $this->connection->getConn()->beginTransaction();

        try {

            $this->connection->getConn()->exec("DELETE FROM {$table} {$where}");
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

}
