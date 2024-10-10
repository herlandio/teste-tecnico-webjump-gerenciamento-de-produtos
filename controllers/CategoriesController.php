<?php

declare(strict_types=1);

namespace Controllers;

use Help\Help;
use Models\ModelCategories;

class CategoriesController {

    /* The line `private ModelCategories ;` in the `CategoriesController` class is declaring a
    private property named `` of type `ModelCategories`. This property is used to store an
    instance of the `ModelCategories` class, which presumably handles interactions with the database
    related to categories. */
    private ModelCategories $database;
    
    /**
     * The above function is a PHP constructor that initializes a new instance of the ModelCategories
     * class.
     */
    public function __construct() {
        $this->database = new ModelCategories();
    }

    /**
     * The function `saveCategories` in PHP saves new categories to the database and returns a JSON
     * response based on the outcome.
     *
     * @return void If the `["REQUEST_METHOD"]` is "POST" and the condition for
     * `empty(->post["newcategory"]) && !isset(->post["newcategory"])` is met, then the
     * method will return a JSON response with a status of "fail" and a HTTP status code of 403.
     */
    public function saveCategories(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            if (empty($_POST["newcategory"]) && !isset($_POST["newcategory"])) {
                echo (new Help())->JSON(false, "fail", 403);
                return;
            }
            
            try {
                $this->database->saveCategories('categories', $_POST);
                echo (new Help())->JSON(true, "created", 201);
            } catch (\Throwable $th) {
                echo (new Help())->JSON(false, $th->getMessage(), 500);
            }
            
        }
    }

    /**
     * This PHP function lists categories from a database and returns them as an array, handling
     * exceptions if they occur.
     *
     * @return array If the `["REQUEST_METHOD"]` is "GET", the function will attempt to list
     * categories from the database using `->database->ListCategories()` method. If successful, it
     * will return the result of `->database->getSelect()`, which is an array of categories. If an
     * exception is caught during the process, it will return an empty array and echo a JSON-encoded
     */
    public function listCategories(): array {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $this->database->listCategories();
                return $this->database->getSelect();
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
     * Delete categories by id
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $this->database->deleteCategories("categories", $id);
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
