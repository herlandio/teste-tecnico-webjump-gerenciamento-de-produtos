<?php


namespace Models;


use Database\Delete;
use Database\Insert;
use Database\Select;
use Database\Update;

class ModelProducts {

    private $update;
    private $selectResult;

    /**
     * List products
     */
    public function listProducts(): array {
        $select = new Select();
        $this->selectResult = $select->select(
            "products",
            ["*"],
            null
        );
        
        return $this->selectResult;
    }

    /**
     * Create products
     *
     * @param string $table
     * @param array $data
     */
    public function saveProducts(string $table, array $data): void {
        $insert = new Insert();
        $insert->Insert($table, [
            "productName" => filter_var($data["name"], FILTER_SANITIZE_STRING),
            "productSku" => filter_var($data["sku"], FILTER_SANITIZE_STRING),
            "productPrice" => filter_var($data["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            "productDescription" => filter_var($data["description"], FILTER_SANITIZE_STRING),
            "productQuantity" => filter_var($data["quantity"], FILTER_SANITIZE_NUMBER_INT),
            "productCategoryOne" => (isset(json_decode($data["category"], true)[0]["category"]))
                ? filter_var(json_decode($data["category"], true)[0]["category"], FILTER_SANITIZE_STRING)
                : NULL,
            "productCategoryTwo" => (isset(json_decode($data["category"], true)[1]["category"]))
                ? filter_var(json_decode($data["category"], true)[1]["category"], FILTER_SANITIZE_STRING)
                : NULL,
            "productCategoryThree" => (isset(json_decode($data["category"], true)[2]["category"]))
                ? filter_var(json_decode($data["category"], true)[2]["category"], FILTER_SANITIZE_STRING)
                : NULL
        ]);
    }

    /**
     * Update products
     *
     * @param string $table
     * @param array $data
     */
    public function updateProducts(string $table, array $data): void {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        $this->update = new Update();
        $this->update->update($table, [
            "productName" => filter_var($data["name"], FILTER_SANITIZE_STRING),
            "productSku" => filter_var($data["sku"], FILTER_SANITIZE_STRING),
            "productPrice" => filter_var($data["price"], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            "productDescription" => filter_var($data["description"], FILTER_SANITIZE_STRING),
            "productQuantity" => filter_var($data["quantity"], FILTER_SANITIZE_NUMBER_INT)
        ], "WHERE productID = '{$id}'");
    }

    /**
     * Delete Products
     *
     * @param string $table
     * @param int $id
     */
    public function deleteProduct(string $table, int $id): void {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $delete = new Delete();
        $delete->Delete($table, "WHERE productID = {$id}");
    }

    /**
     * Return results
     *
     * @return array
     */
    public function getSelect(): array {
        return $this->selectResult;
    }

    /**
     * @return Update
     */

    public function getUpdate(): Update {
        return $this->update;
    }

}
