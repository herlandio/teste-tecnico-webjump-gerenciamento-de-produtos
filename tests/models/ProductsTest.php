<?php

declare(strict_types=1);

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use Models\Products;

/**
 * Class ProductsTest
 *
 * Unit tests for the Products class.
 */
final class ProductsTest extends TestCase
{
    /**
     * Tests the constructor and the getters.
     */
    public function testConstructorAndGetters(): void
    {
        $product = new Products("Laptop", "SKU123", 999.99, "High-performance laptop", 10, "Electronics", "Computers", "Laptops");

        $this->assertEquals("Laptop", $product->getName());
        $this->assertEquals("SKU123", $product->getSku());
        $this->assertEquals(999.99, $product->getPrice());
        $this->assertEquals("High-performance laptop", $product->getDescription());
        $this->assertEquals(10, $product->getQuantity());
        $this->assertEquals("Electronics", $product->getCategoryOne());
        $this->assertEquals("Computers", $product->getCategoryTwo());
        $this->assertEquals("Laptops", $product->getCategoryThree());
    }

    /**
     * Tests the setId method.
     */
    public function testSetId(): void
    {
        $product = new Products("Smartphone", "SKU456", 499.99, "Latest smartphone", 20);
        $product->setId(1);

        $this->assertEquals(1, $product->getId());
    }

    /**
     * Tests the setName method.
     */
    public function testSetName(): void
    {
        $product = new Products("Tablet", "SKU789", 299.99, "Portable tablet", 15);
        $product->setName("New Tablet");

        $this->assertEquals("New Tablet", $product->getName());
    }

    /**
     * Tests the setSku method.
     */
    public function testSetSku(): void
    {
        $product = new Products("Monitor", "SKU111", 199.99, "High-resolution monitor", 5);
        $product->setSku("SKU222");

        $this->assertEquals("SKU222", $product->getSku());
    }

    /**
     * Tests the setPrice method.
     */
    public function testSetPrice(): void
    {
        $product = new Products("Camera", "SKU333", 799.99, "DSLR camera", 8);
        $product->setPrice(749.99);

        $this->assertEquals(749.99, $product->getPrice());
    }

    /**
     * Tests the setDescription method.
     */
    public function testSetDescription(): void
    {
        $product = new Products("Headphones", "SKU444", 149.99, "Noise-canceling headphones", 12);
        $product->setDescription("Wireless noise-canceling headphones");

        $this->assertEquals("Wireless noise-canceling headphones", $product->getDescription());
    }

    /**
     * Tests the setQuantity method.
     */
    public function testSetQuantity(): void
    {
        $product = new Products("Charger", "SKU555", 29.99, "Fast charger", 50);
        $product->setQuantity(60);

        $this->assertEquals(60, $product->getQuantity());
    }

    /**
     * Tests setting categories.
     */
    public function testSetCategories(): void
    {
        $product = new Products("Speaker", "SKU666", 99.99, "Bluetooth speaker", 25);
        $product->setCategoryOne("Audio");
        $product->setCategoryTwo("Wireless");
        $product->setCategoryThree("Portable");

        $this->assertEquals("Audio", $product->getCategoryOne());
        $this->assertEquals("Wireless", $product->getCategoryTwo());
        $this->assertEquals("Portable", $product->getCategoryThree());
    }
}
