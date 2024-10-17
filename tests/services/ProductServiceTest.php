<?php

declare(strict_types=1);

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use Services\ProductService;
use Repositories\ProductRepository;
use Models\Products;
use ReflectionClass;

/**
 * Class ProductServiceTest
 *
 * Test case for ProductService.
 */
class ProductServiceTest extends TestCase
{
    private ProductService $productService;
    private ProductRepository $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(ProductRepository::class);
        $this->productService = new ProductService();

        $reflection = new ReflectionClass(ProductService::class);
        $property = $reflection->getProperty('repository');
        $property->setAccessible(true);
        $property->setValue($this->productService, $this->repositoryMock);
    }

    /**
     * Tests that listProducts returns the correct products.
     */
    public function testListProducts(): void
    {
        $products = [
            new Products('Product 1', 'SKU1', 100.0, 'Description 1', 10, 'Category 1', 'Category 2', 'Category 3'),
            new Products('Product 2', 'SKU2', 150.0, 'Description 2', 20, 'Category 1', 'Category 2', 'Category 3')
        ];

        $this->repositoryMock->expects($this->once())
            ->method('listProducts')
            ->willReturn($products);

        $result = $this->productService->listProducts();
        $this->assertEquals($products, $result);
    }

    /**
     * Tests that saveProduct saves a product.
     */
    public function testSaveProduct(): void
    {
        $data = [
            "name" => "Product 1",
            "sku" => "SKU1",
            "price" => 100.0,
            "description" => "Description 1",
            "quantity" => 10,
            "category" => json_encode([
                ["category" => "Category 1"],
                ["category" => "Category 2"],
                ["category" => "Category 3"]
            ])
        ];

        $this->repositoryMock->expects($this->once())
            ->method('saveProduct')
            ->with($this->isInstanceOf(Products::class));
        
        $this->productService->saveProduct($data);
    }

    /**
     * Tests that updateProduct updates a product.
     */
    public function testUpdateProduct(): void
    {
        $data = [
            "id" => 1,
            "name" => "Updated Product",
            "sku" => "SKU1",
            "price" => 150.0,
            "description" => "Updated Description",
            "quantity" => 15,
            "categoryOne" => "Category 1",
            "categoryTwo" => "Category 2",
            "categoryThree" => "Category 3"
        ];

        $this->repositoryMock->expects($this->once())
            ->method('updateProduct')
            ->with($this->isInstanceOf(Products::class));
            
        ob_start();
        $this->productService->updateProduct($data);
        ob_end_clean();
    }

    /**
     * Tests that deleteProduct deletes a product by ID.
     */
    public function testDeleteProduct(): void
    {
        $productId = 1;
        $this->repositoryMock->expects($this->once())
            ->method('deleteProduct')
            ->with($this->equalTo($productId));
            
        $this->productService->deleteProduct($productId);
    }
}
