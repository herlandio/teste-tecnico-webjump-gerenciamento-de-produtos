<?php

declare(strict_types=1);

namespace Database;

use PDOException;

class Update {

    /* The line `private Connection ;` in the PHP code snippet is declaring a private
    property named `` of type `Connection`. This property is an instance of the
    `Connection` class, which is used to establish a connection to the database. By specifying the
    type `Connection`, it enforces type hinting, ensuring that only objects of the `Connection`
    class can be assigned to this property. This helps in maintaining type safety and clarity in the
    codebase. */
    private Connection $connection;
    
    /* The line `private array ;` in the PHP code snippet is declaring a private property
    named `` of type array. This property is used to store the key-value pairs of the
    columns and their corresponding new values that are being updated in the database table. */
    private array $dataArray;

    /* The line `private string ;` in the PHP code snippet is declaring a private property named
    `` of type string. This property is used to store the concatenated string of key-value
    pairs representing the columns and their corresponding new values that are being updated in the
    database table. */
    private string $data;

    /* The line `private int ;` in the PHP code snippet is declaring a private property named
    `` of type integer. This property is used to store the number of rows affected by the
    update operation in the database table. */
    private int $rowCount;

    /**
     * The above function is a PHP constructor that initializes a new Connection object.
     */
    public function __construct() {
        $this->connection = new Connection();
    }

    /**
     * This PHP function updates records in a database table based on specified fields and conditions,
     * handling transactions and error reporting.
     *
     * @param string table The `table` parameter in the `update` function represents the name of the
     * database table that you want to update. It is a string value that should contain the name of the
     * table where the update operation will be performed.
     * @param array campos The `campos` parameter in the `update` function represents an associative
     * array where the keys are the column names and the values are the new values that you want to
     * update in those columns.
     * @param ?string where The `` parameter in the `update` function is used to specify the condition
     * for updating the records in the database table. It is a string that represents the WHERE clause
     * of the SQL query. This clause is used to filter the rows that need to be updated based on
     * certain conditions.
     */
    public function update(string $table, array $campos, ?string $where): void {

        if (empty($where)) {
            throw new \InvalidArgumentException("A cláusula WHERE é obrigatória para atualizar registros.");
        }
    
        $this->dataArray = [];
        foreach ($campos as $key => $value) {
            $this->dataArray[] = "$key = ?";
        }
        $this->data = implode(', ', $this->dataArray);
        
        $this->connection->getConn()->beginTransaction();
    
        try {

            $statement = $this->connection->getConn()->prepare("UPDATE {$table} SET {$this->data} {$where}");
            $values = array_values($campos);
            $statement->execute($values);
            $this->rowCount = $statement->rowCount();
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
     * The function countChange() returns the value of the rowCount property.
     *
     * @return int The `rowCount` property of the current object is being returned.
     */
    public function countChange(): int {
        return $this->rowCount;
    }
}
