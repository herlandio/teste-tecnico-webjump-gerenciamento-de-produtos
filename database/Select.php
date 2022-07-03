<?php


namespace Database;

use PDO;
use PDOException;

class Select {

    private $rowCount;

    /**
     * Generic selection function
     * @param $table
     * @param array $fields :: array('key') where the key is the database column name
     * @param null $where :: example "WHERE id=5"
     * @return mixed
     */

    function Select($table, $fields = array(), $where = null) {

        $connection = new Connection();
        $connection->initDatabase();

        $fields1 = implode(', ', $fields);

        $connection->getConn()->beginTransaction();

        try {

            $statement = $connection->getConn()->prepare("SELECT {$fields1} FROM {$table} {$where}");
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $this->rowCount = $statement->rowCount();
            $connection->getConn()->commit();
            return $statement->fetchAll();

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
}