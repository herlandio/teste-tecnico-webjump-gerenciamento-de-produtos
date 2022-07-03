<?php


namespace Database;


use PDOException;

class Insert {

    private $lastID;

    /**
     * Insert database
     * @param $table
     * @param $data :: array('key' => 'value') where the key is the name of the column in the database
     */

    public function Insert($table, $data) {

        $connection = new Connection();
        $connection->initDatabase();

        $column = implode(', ', array_keys($data));
        $values = "'".implode("', '", array_values($data))."'";

        $connection->getConn()->beginTransaction();

        try {

            $statement = $connection->getConn()->prepare("INSERT INTO $table ({$column}) VALUES ({$values})");
            $statement->bindParam("{$values}", $values);
            $statement->execute();
            $this->lastID = $connection->getConn()->lastInsertId();
            $connection->getConn()->commit();
        } catch (PDOException $e) {

            $connection->getConn()->rollBack();

            echo json_encode([
                "File" => $e->getFile(),
                "Line" => $e->getLine(),
                "Message" => $e->getMessage(),
                "CodeError" => $e->getCode()
            ]);
        }

        $connection->libertyConection();
    }

    /**
     * Return last inserted ID
     * @return int
     */

    public function lastId() {
        return $this->lastID;
    }
}