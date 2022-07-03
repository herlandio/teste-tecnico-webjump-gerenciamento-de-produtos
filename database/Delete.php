<?php


namespace Database;


use PDOException;

class Delete {

    /**
     * Generic data deletion function
     *
     * @param $table
     * @param $where :: example WHERE id = 1
     */

    public function Delete($table, $where) {

        $connection = new Connection();
        $connection->initDatabase();

        $connection->getConn()->beginTransaction();

        try {

            $connection->getConn()->exec("DELETE FROM {$table} {$where}");
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

}