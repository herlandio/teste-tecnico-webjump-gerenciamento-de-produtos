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
    public function ListProducts() {
        $select = new Select();
        $this->selectResult = $select->select(
            "products",
            ["*"],
            null
        );
    }

    /**
     * Create products
     * @param $table
     * @param $data
     */
    public function SaveProducts($table, $data) {
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
     * @param $table
     * @param $data
     */
    public function UpdateProducts($table, $data) {
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
     * @param $table
     * @param $id
     */
    public function DeleteProduct($table, $id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $delete = new Delete();
        $delete->Delete($table, "WHERE productID = {$id}");
    }

    /**
     * @return mixed
     */

    public function getSelect() { return $this->selectResult; }

    /**
     * @return Update
     */

    public function getUpdate() { return $this->update; }


}