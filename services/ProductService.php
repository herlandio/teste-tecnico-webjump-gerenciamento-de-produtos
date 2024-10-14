<?php

declare(strict_types=1);

namespace Services;

use Help\Help;
use Models\Products;
use Repositories\ProductRepository;

/**
 * Class ProductService
 *
 * Service layer responsible for handling business logic related to products.
 */
class ProductService {

    private ProductRepository $repository;
    
    private array $post;

    /**
     * Constructor to initialize the repository.
     */
    public function __construct() {
        $this->post = $_POST;
        $this->repository = new ProductRepository();
    }

    /**
     * Retrieves all products from the repository.
     *
     * @return Products[] An array of Product objects.
     */
    public function listProducts(): array {
        return $this->repository->listProducts();
    }

    /**
     * Creates and saves a new product based on the provided data.
     *
     * @param array $data Data for the new product, including name, sku, price, description, quantity, and categories.
     * @return void
     */
    public function saveProduct(array $data): void {
        
        if (!$this->validateProductData($data)) {
            echo (new Help())->json(false, "Please fill in all required fields.", 403);
            exit();
        }
    
        $product = new Products(
            $data["name"],
            $data["sku"],
            (float) $data["price"],
            $data["description"],
            (int) $data["quantity"],
            $this->getCategory($data["category"], 0),
            $this->getCategory($data["category"], 1),
            $this->getCategory($data["category"], 2)
        );
    
        $this->repository->saveProduct($product);
    }
    
    /**
     * Validate the product data.
     *
     * @param array $data
     * @return bool
     */
    private function validateProductData(array $data): bool {
        return !empty($data["name"]) &&
               !empty($data["sku"]) &&
               !empty($data["price"]) &&
               !empty($data["description"]) &&
               !empty($data["quantity"]) &&
               !empty($data["category"][0]);
    }
    
    /**
     * Extract and sanitize a category from JSON data.
     *
     * @param string $categoryJson
     * @param int $index
     * @return string|null
     */
    private function getCategory(string $categoryJson, int $index): ?string {
        $categories = json_decode($categoryJson, true);
        return isset($categories[$index]["category"]) ? filter_var($categories[$index]["category"], FILTER_SANITIZE_STRING) : null;
    }

    /**
     * Updates an existing product with the provided data.
     *
     * @param array $data Data for updating the product, including name, sku, price, description, quantity, and categories.
     * @return void
     */
    public function updateProduct(array $data): void {
        if (
            empty($this->post["name"]) &&
            empty($this->post["sku"]) &&
            empty($this->post["price"]) &&
            empty($this->post["description"]) &&
            empty($this->post["quantity"])
        ) {
            echo (new Help())->json(false, "Preencha todos os campos obrigatórios.", 403);
        }

        $product = new Products(
            $data["name"],
            $data["sku"],
            (float) $data["price"],
            $data["description"],
            (int) $data["quantity"],
            $data["categoryOne"],
            $data["categoryTwo"] ?? null,
            $data["categoryThree"] ?? null
        );
        $product->setId((int) $data['id']);
        $this->repository->updateProduct($product);
    }

    /**
     * Deletes a product by its ID.
     *
     * @param int $id The ID of the product to be deleted.
     * @return void
     */
    public function deleteProduct(int $id): void {
        $this->repository->deleteProduct($id);
    }
}
