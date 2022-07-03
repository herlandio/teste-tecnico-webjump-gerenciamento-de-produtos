<?php

namespace Controllers;

use Help\BaseView;
use Help\Help;
use Models\ModelProducts;

class ProductsController {

    private $database;
    private $post;

    public function __construct() {
        $this->post = $_POST;
        $this->database = new ModelProducts();
    }

    /**
     * Define a view
     */
    public function Product() {
        $baseView = new BaseView();
        /**
         * Set title for page
         */
        $baseView->setTitle('Adicionar Produtos');

        /**
         * Set folder of view
         */
        $baseView->Folder('Product/');
    }

    /**
     * Create Products
     */
    public function Save() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($this->post)) {
                if (
                    !empty($this->post["category"][0]) &&
                    !empty($this->post["name"]) &&
                    !empty($this->post["sku"]) &&
                    !empty($this->post["price"]) &&
                    !empty($this->post["description"]) &&
                    !empty($this->post["quantity"])
                ) {
                    $this->database->SaveProducts('products', $this->post);
                    echo (new Help())->JSON(true, "created", 201);
                } else {
                    echo (new Help())->JSON(false, "fail", 403);
                }
            }
        }
    }

    /**
     * Update Products
     */
    public function Update() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($this->post)) {
                if (
                    !empty($this->post["name"]) &&
                    !empty($this->post["sku"]) &&
                    !empty($this->post["price"]) &&
                    !empty($this->post["description"]) &&
                    !empty($this->post["quantity"])
                ) {
                    $this->database->UpdateProducts('products', $this->post);
                    echo (new Help())->JSON(true, "updated", 204);
                } else {
                    echo (new Help())->JSON(false, "fail", 403);
                }
            }
        }
    }

    /**
     * Delete Products
     * @param $id
     */
    public function Delete($id) {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $this->database->DeleteProduct("products", $id);
            header("Location: /");
        }
    }

    /**
     * List products
     */
    public function ListProducts() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $products = new ModelProducts();
            $products->ListProducts();
            return $products->getSelect();
        }
    }

}
