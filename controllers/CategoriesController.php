<?php

declare(strict_types=1);

namespace Controllers;

use Help\Help;
use Models\Category;
use Services\CategoriesService;

/**
 * Class CategoriesController
 *
 * This controller handles category-related operations such as creating, listing, and deleting categories.
 */
class CategoriesController {

    /**
     * @var CategoriesService $service The service responsible for category operations.
     */
    private CategoriesService $service;

    /**
     * CategoriesController constructor.
     * Initializes the service to manage categories.
     */
    public function __construct() {
        $this->service = new CategoriesService();
    }

    /**
     * Create a new category.
     * Handles the POST request to create a category.
     *
     * @return void
     */
    public function saveCategories(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $this->service->createCategory($_POST["newcategory"]);
                echo (new Help())->json(true, "created", 201);
            } catch (\InvalidArgumentException $e) {
                echo (new Help())->json(false, $e->getMessage(), 403);
            } catch (\Exception $e) {
                echo (new Help())->json(false, $e->getMessage(), 500);
            }
        }
    }

    /**
     * List all categories.
     * Handles the GET request to retrieve a list of categories.
     *
     * @return array An array of categories with categoryID and categoryName.
     */
    public function listCategories(): array {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $categories = $this->service->listCategories();
                
                return array_map(function(Category $category) {
                    return [
                        'categoryID' => $category->getCategoryID(),
                        'categoryName' => $category->getCategoryName()
                    ];
                }, $categories);

            } catch (\Exception $e) {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao listar categorias: " . $e->getMessage(),
                    "code" => $e->getCode()
                ]);
                return [];
            }
        }
        return [];
    }

    /**
     * Delete a category by ID.
     * Handles the GET request to delete a category based on its ID.
     *
     * @param int $id The ID of the category to be deleted.
     * @return void
     */
    public function delete(int $id): void {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $this->service->deleteCategory($id);
                header("Location: /");
                exit();
            } catch (\Exception $e) {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao deletar categoria: " . $e->getMessage(),
                    "code" => $e->getCode()
                ]);
            }
        }
    }
}

