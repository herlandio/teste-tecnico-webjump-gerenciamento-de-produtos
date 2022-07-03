<?php


namespace Database;


use PDOException;

class Update {

    private $dataArray;
    private $data;
    private $rowCount;

    /**
     * Function responsible for updating data
     *
     * @param $table
     * @param $campos :: example array('key' => 'value') where the key is the name of the column in the database
     * @param null $where
     */

    function Update($table, $campos, $where = null) {

        $connection = new Connection();
        $connection->initDatabase();

        foreach ($campos as $key => $value) {
            $this->dataArray[] = $key." = '".$value."'";
            $join = implode(', ', $this->dataArray);
            $this->data = $join;
        }

        $connection->getConn()->beginTransaction();

        try {

            $statement = $connection->getConn()->prepare("UPDATE {$table} SET {$this->data} {$where}");
            $statement->execute();
            $this->rowCount = $statement->rowCount();
            $connection->getConn()->commit();

        } catch(PDOException $e) {

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
     * Function responsible for counting updated rows after update
     * @return int
     */

    public function countChange() {
        return $this->rowCount;
    }
}