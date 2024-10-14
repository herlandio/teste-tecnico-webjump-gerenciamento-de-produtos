<?php

declare(strict_types=1);

namespace Models;

/**
 * Class Products
 *
 * This class represents a product entity with various attributes such as name, SKU, price, description, quantity, and categories.
 */
class Products {

    /**
     * @var int $id The unique identifier of the product.
     */
    private int $id;

    /**
     * @var string $name The name of the product.
     */
    private string $name;

    /**
     * @var string $sku The SKU (Stock Keeping Unit) of the product.
     */
    private string $sku;

    /**
     * @var float $price The price of the product.
     */
    private float $price;

    /**
     * @var string $description A description of the product.
     */
    private string $description;

    /**
     * @var int $quantity The available quantity of the product.
     */
    private int $quantity;

    /**
     * @var string|null $categoryOne The first category of the product, if any.
     */
    private ?string $categoryOne;

    /**
     * @var string|null $categoryTwo The second category of the product, if any.
     */
    private ?string $categoryTwo;

    /**
     * @var string|null $categoryThree The third category of the product, if any.
     */
    private ?string $categoryThree;

    /**
     * Products constructor.
     *
     * @param string $name The name of the product.
     * @param string $sku The SKU of the product.
     * @param float $price The price of the product.
     * @param string $description A description of the product.
     * @param int $quantity The quantity of the product.
     * @param string|null $categoryOne The first category of the product (optional).
     * @param string|null $categoryTwo The second category of the product (optional).
     * @param string|null $categoryThree The third category of the product (optional).
     */
    public function __construct(
        string $name,
        string $sku,
        float $price,
        string $description,
        int $quantity,
        ?string $categoryOne = null,
        ?string $categoryTwo = null,
        ?string $categoryThree = null
    ) {
        $this->name = $name;
        $this->sku = $sku;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->categoryOne = $categoryOne;
        $this->categoryTwo = $categoryTwo;
        $this->categoryThree = $categoryThree;
    }

    /**
     * Get the product ID.
     *
     * @return int The unique identifier of the product.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Set the product ID.
     *
     * @param int $id The unique identifier of the product.
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * Get the product name.
     *
     * @return string The name of the product.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the product name.
     *
     * @param string $name The name of the product.
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Get the product SKU.
     *
     * @return string The SKU of the product.
     */
    public function getSku(): string {
        return $this->sku;
    }

    /**
     * Set the product SKU.
     *
     * @param string $sku The SKU of the product.
     */
    public function setSku(string $sku): void {
        $this->sku = $sku;
    }

    /**
     * Get the product price.
     *
     * @return float The price of the product.
     */
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * Set the product price.
     *
     * @param float $price The price of the product.
     */
    public function setPrice(float $price): void {
        $this->price = $price;
    }

    /**
     * Get the product description.
     *
     * @return string The description of the product.
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Set the product description.
     *
     * @param string $description The description of the product.
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * Get the product quantity.
     *
     * @return int The available quantity of the product.
     */
    public function getQuantity(): int {
        return $this->quantity;
    }

    /**
     * Set the product quantity.
     *
     * @param int $quantity The available quantity of the product.
     */
    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    /**
     * Get the first product category.
     *
     * @return string|null The first category of the product.
     */
    public function getCategoryOne(): ?string {
        return $this->categoryOne;
    }

    /**
     * Set the first product category.
     *
     * @param string|null $categoryOne The first category of the product.
     */
    public function setCategoryOne(?string $categoryOne): void {
        $this->categoryOne = $categoryOne;
    }

    /**
     * Get the second product category.
     *
     * @return string|null The second category of the product.
     */
    public function getCategoryTwo(): ?string {
        return $this->categoryTwo;
    }

    /**
     * Set the second product category.
     *
     * @param string|null $categoryTwo The second category of the product.
     */
    public function setCategoryTwo(?string $categoryTwo): void {
        $this->categoryTwo = $categoryTwo;
    }

    /**
     * Get the third product category.
     *
     * @return string|null The third category of the product.
     */
    public function getCategoryThree(): ?string {
        return $this->categoryThree;
    }

    /**
     * Set the third product category.
     *
     * @param string|null $categoryThree The third category of the product.
     */
    public function setCategoryThree(?string $categoryThree): void {
        $this->categoryThree = $categoryThree;
    }
}
