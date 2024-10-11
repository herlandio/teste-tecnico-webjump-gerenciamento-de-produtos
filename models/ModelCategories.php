<?php

declare(strict_types=1);

namespace Models;

use Database\Delete;
use Database\Insert;
use Database\Select;

class ModelCategories {

    private array $selectResult;

    /**
     * Create categories
     *
     * @param string $table
     * @param array $data
     */
    public function saveCategories(string $table, array $data): void {
        $insert = new Insert();
        $insert->insert($table, [
            "categoryName" => filter_var($data["newcategory"], FILTER_SANITIZE_STRING)
        ]);
    }

    /**
     * List categories
     */
    public function listCategories(): array {
        $select = new Select();
        $this->selectResult = $select->Select(
            "categories",
            ["*"],
            null
        );
        return $this->selectResult;
    }

    /**
     * Delete categories
     *
     * @param string $table
     * @param int $id
     */
    public function deleteCategories(string $table, int $id): void {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $delete = new Delete();
        $delete->delete($table, "WHERE categoryID = {$id}");
    }

    /**
     * Return results
     *
     * @return array
     */
    public function getSelect(): array {
        return $this->selectResult;
    }

}
