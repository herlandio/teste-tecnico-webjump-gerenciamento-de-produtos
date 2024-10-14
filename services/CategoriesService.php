<?php

declare(strict_types=1);

namespace Services;

use Repositories\CategoriesRepository;
use Models\Category;

/**
 * Class CategoriesService
 *
 * Service layer for handling business logic related to categories.
 */
class CategoriesService {

    private CategoriesRepository $repository;

    /**
     * Constructor to initialize the repository.
     */
    public function __construct() {
        $this->repository = new CategoriesRepository();
    }

    /**
     * Creates a new category.
     *
     * @param string $categoryName The name of the category to be created.
     * @return void
     */
    public function createCategory(string $categoryName): void {

        if (empty($categoryName)) {
            throw new \InvalidArgumentException("O nome da categoria não pode estar vazio.");
        }
        
        $categoryName   = filter_var($categoryName, FILTER_SANITIZE_STRING);
        $category = new Category($categoryName);
        $this->repository->saveCategory([
            'categoryName' => $category->getCategoryName()
        ]);
    }

    /**
     * Retrieves all categories from the repository and returns them as an array of Category objects.
     *
     * @return Category[] An array of Category objects.
     */
    public function listCategories(): array {
        $categoriesData = $this->repository->getAllCategories();
        $categories = [];
        
        foreach ($categoriesData as $categoryData) {
            $categories[] = new Category($categoryData['categoryName'], (int) $categoryData['categoryID']);
        }

        return $categories;
    }

    /**
     * Deletes a category by its ID.
     *
     * @param int $id The ID of the category to be deleted.
     * @return void
     */
    public function deleteCategory(int $id): void {
        $this->repository->deleteCategoryById($id);
    }
}
