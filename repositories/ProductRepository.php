<?php

declare(strict_types=1);

namespace Repositories;

use Database\Delete;
use Database\Insert;
use Database\Select;
use Database\Update;
use Models\Products;

/**
 * Class ProductRepository
 *
 * Repository responsible for handling database operations related to products.
 */
class ProductRepository {

    private Insert $insert;
    private Select $select;
    private Update $update;
    private Delete $delete;

    /**
     * ProductRepository constructor.
     *
     * Initializes the Insert, Select, Update, and Delete classes for use
     * in database operations.
     */
    public function __construct() {
        $this->insert = new Insert();
        $this->select = new Select();
        $this->update = new Update();
        $this->delete = new Delete();
    }

    /**
     * Retrieves all products from the database.
     *
     * @return array An array of Products objects.
     */
    public function listProducts(): array {
        $result = $this->select->select("products", ["*"]);

        $products = [];
        foreach ($result as $row) {
            $product = new Products(
                $row['productName'],
                $row['productSku'],
                (float) $row['productPrice'],
                $row['productDescription'],
                (int) $row['productQuantity'],
                $row['productCategoryOne'],
                $row['productCategoryTwo'],
                $row['productCategoryThree']
            );
            $product->setId((int) $row['productID']);
            $products[] = $product;
        }

        return $products;
    }

    /**
     * Saves a new product to the database.
     *
     * @param Products $product The product to be saved.
     * @return void
     */
    public function saveProduct(Products $product): void {
        $this->insert->insert("products", [
            "productName" => $product->getName(),
            "productSku" => $product->getSku(),
            "productPrice" => $product->getPrice(),
            "productDescription" => $product->getDescription(),
            "productQuantity" => $product->getQuantity(),
            "productCategoryOne" => $product->getCategoryOne(),
            "productCategoryTwo" => $product->getCategoryTwo(),
            "productCategoryThree" => $product->getCategoryThree()
        ]);
    }

    /**
     * Updates an existing product in the database.
     *
     * @param Products $product The product with updated data.
     * @return void
     */
    public function updateProduct(Products $product): void {
        $this->update->update("products", [
            "productName" => $product->getName(),
            "productSku" => $product->getSku(),
            "productPrice" => $product->getPrice(),
            "productDescription" => $product->getDescription(),
            "productQuantity" => $product->getQuantity()
        ], "productID = " . $product->getId());
    }

    /**
     * Deletes a product from the database by its ID.
     *
     * @param int $id The ID of the product to delete.
     * @return void
     */
    public function deleteProduct(int $id): void {
        $this->delete->delete("products", "productID = {$id}");
    }
}


