<?php

declare(strict_types=1);

namespace Models;

/**
 * Class Category
 *
 * This class represents a category entity with an ID and a name.
 */
class Category {

    /**
     * @var ?int $categoryID The unique identifier of the category.
     */
    private ?int $categoryID;

    /**
     * @var string $categoryName The name of the category.
     */
    private string $categoryName;

    /**
     * Category constructor.
     *
     * @param string $categoryName The name of the category.
     * @param ?int $categoryID The ID of the category (default is 0 for new categories).
     */
    public function __construct(string $categoryName, ?int $categoryID = 0) {
        $this->setCategoryName($categoryName);
        $this->categoryID = $categoryID;
    }

    /**
     * Get the category ID.
     *
     * @return ?int The unique identifier of the category.
     */
    public function getCategoryID(): ?int {
        return $this->categoryID;
    }

    /**
     * Set the category ID.
     *
     * @param ?int $categoryID The unique identifier of the category.
     * @return void
     */
    public function setCategoryID(?int $categoryID): void {
        $this->categoryID = $categoryID;
    }

    /**
     * Get the category name.
     *
     * @return string The name of the category.
     */
    public function getCategoryName(): string {
        return $this->categoryName;
    }

    /**
     * Set the category name.
     *
     * @param string $categoryName The name of the category.
     * @return void
     */
    public function setCategoryName(string $categoryName): void {
        $this->categoryName = $categoryName;
    }
}
