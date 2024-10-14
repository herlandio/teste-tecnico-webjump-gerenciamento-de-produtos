<?php

declare(strict_types=1);

namespace Repositories;

use Database\Select;
use Database\Insert;
use Database\Delete;

/**
 * Class CategoriesRepository
 *
 * This class handles the database operations related to categories,
 * including saving, retrieving, and deleting categories.
 */
class CategoriesRepository {

    private Insert $insert;
    private Select $select;
    private Delete $delete;

    /**
     * CategoriesRepository constructor.
     *
     * Initializes the Insert, Select, and Delete classes for use
     * in database operations.
     */
    public function __construct() {
        $this->insert = new Insert();
        $this->select = new Select();
        $this->delete = new Delete();
    }

    /**
     * Saves a new category to the database.
     *
     * @param array $data The category data to be saved.
     * @return void
     */
    public function saveCategory(array $data): void {
        $this->insert->insert('categories', $data);
    }

    /**
     * Retrieves all categories from the database.
     *
     * @return array An array of categories.
     */
    public function getAllCategories(): array {
        return $this->select->select('categories', ['*']);
    }

    /**
     * Deletes a category from the database by its ID.
     *
     * @param int $id The ID of the category to delete.
     * @return void
     */
    public function deleteCategoryById(int $id): void {
        $this->delete->delete('categories', "categoryID = {$id}");
    }
}

