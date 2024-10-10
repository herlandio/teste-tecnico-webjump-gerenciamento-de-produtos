<?php

declare(strict_types=1);

namespace Database;

use PDO;
use PDOException;

/* The `class Select` in the provided PHP code is a part of a database-related namespace and contains
methods for executing SELECT queries on a database using PDO (PHP Data Objects). Here is a breakdown
of what the `class Select` is doing: */
class Select {

    /* The line `private Connection ;` in the code is declaring a private property named
    `` within the `Select` class. This property is typed with the `Connection` class,
    indicating that it can only hold objects of type `Connection`. */
    private Connection $connection;

    /* The `private int ;` line in the code is declaring a private property `` of
    type integer within the `Select` class. This property is used to store the number of rows
    affected by the most recent SELECT query executed by the `select` method of the `Select` class.
    It is initialized to 0 when the `Select` class is instantiated and is updated with the row count
    after executing a SELECT query. */
    private int $rowCount;

    /**
     * The above function is a PHP constructor that initializes a new Connection object.
     */
    public function __construct() {
        $this->connection = new Connection();
    }

    /**
     * The function `select` retrieves data from a specified table in a database using PDO in PHP,
     * handling transactions and error reporting.
     *
     * @param string table The `table` parameter in the `select` function represents the name of the
     * database table from which you want to retrieve data. It is a required parameter for the function
     * and should be passed as a string containing the name of the table you want to query.
     * @param array fields The `select` function you provided is used to fetch data from a database
     * table based on the specified fields and conditions. The parameters for the function are as
     * follows:
     * @param ?string where The `` parameter in the `select` function is used to specify the conditions
     * for filtering the rows in the SQL query. It allows you to add a WHERE clause to the SELECT
     * statement in order to retrieve only the rows that meet the specified conditions.
     *
     * @return array An array of data fetched from the database table based on the specified fields and
     * conditions provided in the SELECT query. If an error occurs during the execution, an empty array
     * will be returned, and details of the error will be echoed in JSON format.
     */
    public function select(string $table, array $fields = [], ?string $where = ''): array {
        
        if (empty($fields)) {
            throw new \InvalidArgumentException("Os campos para selecionar não podem estar vazios.");
        }
    
        $explodeFields = implode(', ', $fields);
    
        try {
            $sql = "SELECT {$explodeFields} FROM {$table}";
    
            if (!empty($where)) {
                $sql .= " WHERE {$where}";
            }
    
            $statement = $this->connection->getConn()->prepare($sql);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
    
            $result = $statement->fetchAll();
            $this->rowCount = count($result);
    
            return $result;
    
        } catch (PDOException $e) {
            
            echo json_encode([
                "File" => $e->getFile(),
                "Line" => $e->getLine(),
                "Message" => $e->getMessage(),
                "CodeError" => $e->getCode()
            ]);
    
            return [];

        } finally {
            $this->connection->libertyConnection();
        }
    }

}
