<?php

declare(strict_types=1);

namespace Controllers;

use Help\BaseView;
use Help\Help;
use Models\ModelProducts;

class ProductsController {

    private ModelProducts $database;
    private array $post;

    public function __construct() {
        $this->post = $_POST;
        $this->database = new ModelProducts();
    }

    /**
     * Define a view
     */
    public function product(): void {
        $baseView = new BaseView();
        $baseView->setTitle('Adicionar Produtos');
        $baseView->folder('Product/');
    }

    /**
     * Create Products
     */
    public function save(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (
                !empty($this->post["category"][0]) &&
                !empty($this->post["name"]) &&
                !empty($this->post["sku"]) &&
                !empty($this->post["price"]) &&
                !empty($this->post["description"]) &&
                !empty($this->post["quantity"])
            ) {
                try {
                    $this->database->saveProducts('products', $this->post);
                    echo (new Help())->JSON(true, "Produto criado com sucesso.", 201);
                } catch (\Exception $e) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Erro ao salvar produto: " . $e->getMessage(),
                        "code" => $e->getCode()
                    ]);
                }
            } else {
                echo (new Help())->JSON(false, "Preencha todos os campos obrigatórios.", 403);
            }
        }
    }
    

    /**
     * Update Products
     */
    public function update(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (
                !empty($this->post["name"]) &&
                !empty($this->post["sku"]) &&
                !empty($this->post["price"]) &&
                !empty($this->post["description"]) &&
                !empty($this->post["quantity"])
            ) {
                try {
                    $this->database->updateProducts('products', $this->post);
                    echo (new Help())->JSON(true, "Produto atualizado com sucesso.", 200);
                } catch (\Exception $e) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Erro ao atualizar produto: " . $e->getMessage(),
                        "code" => $e->getCode()
                    ]);
                }
            } else {
                echo (new Help())->JSON(false, "Preencha todos os campos obrigatórios.", 403);
            }
        }
    }

    /**
     * Delete Products
     * @param int $id
     */
    public function delete(int $id): void {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $this->database->deleteProduct("products", $id);
                header("Location: /");
            } catch (\Exception $e) {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao excluir produto: " . $e->getMessage(),
                    "code" => $e->getCode()
                ]);
            }
        }
    }

    /**
     * List products
     */
    public function listProducts(): array {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $products = new ModelProducts();
                $products->listProducts();
                return $products->getSelect();
            } catch (\Exception $e) {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao listar produtos: " . $e->getMessage(),
                    "code" => $e->getCode()
                ]);
                return [];
            }
        }
        return [];
    }

}
