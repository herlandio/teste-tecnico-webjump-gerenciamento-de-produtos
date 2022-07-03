<?php


namespace Controllers;


use Help\Help;
use Models\ModelCategories;

class CategoriesController {

    private $database;
    private $post;

    public function __construct() {
        $this->post = $_POST;
        $this->database = new ModelCategories();
    }

    /**
     * Create categories
     */
    public function SaveCategories() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($this->post)) {
                if (!empty($this->post["newcategory"])) {
                    $this->database->SaveCategories('categories', $this->post);
                    echo (new Help())->JSON(true, "created", 201);
                } else {
                    echo (new Help())->JSON(false, "fail", 403);
                }
            }
        }
    }

    /**
     * List categories
     * @return mixed
     */
    public function ListCategories() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $this->database->ListCategories();
            return $this->database->getSelect();
        }
    }

    /**
     * Delete categories
     * @param $id
     */
    public function Delete($id) {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $this->database->DeleteCategories("categories", $id);
            header("Location: /");
        }
    }
}