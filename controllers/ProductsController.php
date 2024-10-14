<?php

declare(strict_types=1);

namespace Controllers;

use Help\BaseView;
use Services\ProductService;
use Help\Help;

/**
 * Class ProductsController
 *
 * This controller manages operations related to products, including creation, updating, deletion, and listing of products.
 */
class ProductsController {

    /**
     * @var ProductService $service The service responsible for handling product operations.
     */
    private ProductService $service;

    /**
     * ProductsController constructor.
     * Initializes the service and captures POST data.
     */
    public function __construct() {
        $this->service = new ProductService();
    }

    /**
     * Define the view for product operations.
     * Sets the page title and folder for the view.
     *
     * @return void
     */
    public function product(): void {
        $baseView = new BaseView();
        $baseView->setTitle('Adicionar Produtos');
        $baseView->folder('Product/');
    }

    /**
     * Save a new product.
     * Handles POST requests to create a new product.
     *
     * @return void
     */
    public function save(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $this->service->saveProduct($_POST);
                echo (new Help())->json(true, "Produto criado com sucesso.", 201);
            } catch (\Exception $e) {
                echo json_encode([
                    "success"   => false,
                    "message"   => "Erro ao salvar produto: " . $e->getMessage(),
                    "code"      => $e->getCode()
                ]);
            }
        }
    }

    /**
     * Update an existing product.
     * Handles POST requests to update a product's information.
     *
     * @return void
     */
    public function update(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $this->service->updateProduct($_POST);
                echo (new Help())->json(true, "Produto atualizado com sucesso.", 200);
            } catch (\Exception $e) {
                echo json_encode([
                    "success"   => false,
                    "message"   => "Erro ao atualizar produto: " . $e->getMessage(),
                    "code"      => $e->getCode()
                ]);
            }
        }
    }

    /**
     * Delete a product by its ID.
     * Handles GET requests to delete a product.
     *
     * @param int $id The ID of the product to be deleted.
     * @return void
     */
    public function delete(int $id): void {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $this->service->deleteProduct($id);
                header("Location: /");
            } catch (\Exception $e) {
                echo json_encode([
                    "success"   => false,
                    "message"   => "Erro ao excluir produto: " . $e->getMessage(),
                    "code"      => $e->getCode()
                ]);
            }
        }
    }

    /**
     * List all products.
     * Handles GET requests to retrieve a list of products.
     *
     * @return array An array of products with detailed information.
     */
    public function listProducts(): array {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $products = $this->service->listProducts();
                return array_map(function($product) {
                    return [
                        'id'            => $product->getId(),
                        'name'          => $product->getName(),
                        'sku'           => $product->getSku(),
                        'price'         => $product->getPrice(),
                        'description'   => $product->getDescription(),
                        'quantity'      => $product->getQuantity(),
                        'categoryOne'   => $product->getCategoryOne(),
                        'categoryTwo'   => $product->getCategoryTwo(),
                        'categoryThree' => $product->getCategoryThree(),
                    ];
                }, $products);

            } catch (\Exception $e) {
                echo json_encode([
                    "success"   => false,
                    "message"   => "Erro ao listar produtos: " . $e->getMessage(),
                    "code"      => $e->getCode()
                ]);
                return [];
            }
        }
        return [];
    }
}

