<?php


namespace Models;


use Database\Delete;
use Database\Insert;
use Database\Select;

class ModelCategories {

    private $selectResult;

    /**
     * Create categories
     * @param $table
     * @param $data
     */
    public function SaveCategories($table, $data) {
        $insert = new Insert();
        $insert->Insert($table, [
            "categoryName" => filter_var($data["newcategory"], FILTER_SANITIZE_STRING)
        ]);
    }

    /**
     * List categories
     */
    public function ListCategories() {
        $select = new Select();
        $this->selectResult = $select->Select(
            "categories",
            ["*"],
            null
        );
    }

    /**
     * Delete categories
     * @param $table
     * @param $id
     */
    public function DeleteCategories($table, $id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $delete = new Delete();
        $delete->Delete($table, "WHERE categoryID = {$id}");
    }

    /**
     * @return mixed
     */

    public function getSelect() { return $this->selectResult; }


}