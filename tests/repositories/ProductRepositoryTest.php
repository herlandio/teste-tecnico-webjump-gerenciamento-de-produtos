<?php

declare(strict_types=1);

namespace Tests\Repositories;

use PHPUnit\Framework\TestCase;
use Repositories\ProductRepository;
use Database\Insert;
use Database\Select;
use Database\Update;
use Database\Delete;
use Models\Products;

class ProductRepositoryTest extends TestCase
{
    private ProductRepository $productRepository;
    private Insert $insertMock;
    private Select $selectMock;
    private Update $updateMock;
    private Delete $deleteMock;

    protected function setUp(): void
    {
        $this->insertMock = $this->createMock(Insert::class);
        $this->selectMock = $this->createMock(Select::class);
        $this->updateMock = $this->createMock(Update::class);
        $this->deleteMock = $this->createMock(Delete::class);

        $this->productRepository = new ProductRepository();
        $this->setProtectedProperty($this->productRepository, 'insert', $this->insertMock);
        $this->setProtectedProperty($this->productRepository, 'select', $this->selectMock);
        $this->setProtectedProperty($this->productRepository, 'update', $this->updateMock);
        $this->setProtectedProperty($this->productRepository, 'delete', $this->deleteMock);
    }

    /**
     * Tests that listProducts returns a list of products.
     */
    public function testListProducts(): void
    {
        $this->selectMock->method('select')->willReturn([
            [
                'productID' => 1,
                'productName' => 'Test Product',
                'productSku' => 'SKU123',
                'productPrice' => 99.99,
                'productDescription' => 'A sample product',
                'productQuantity' => 10,
                'productCategoryOne' => 'Category1',
                'productCategoryTwo' => 'Category2',
                'productCategoryThree' => 'Category3',
            ]
        ]);

        $products = $this->productRepository->listProducts();

        $this->assertCount(1, $products);
        $this->assertInstanceOf(Products::class, $products[0]);
        $this->assertEquals('Test Product', $products[0]->getName());
    }

    /**
     * Tests that saveProduct inserts a product into the database.
     */
    public function testSaveProduct(): void
    {
        $product = new Products('Test Product', 'SKU123', 99.99, 'A sample product', 10, 'Category1', 'Category2', 'Category3');

        $this->insertMock->expects($this->once())
            ->method('insert')
            ->with(
                'products',
                [
                    'productName' => $product->getName(),
                    'productSku' => $product->getSku(),
                    'productPrice' => $product->getPrice(),
                    'productDescription' => $product->getDescription(),
                    'productQuantity' => $product->getQuantity(),
                    'productCategoryOne' => $product->getCategoryOne(),
                    'productCategoryTwo' => $product->getCategoryTwo(),
                    'productCategoryThree' => $product->getCategoryThree()
                ]
            );

        $this->productRepository->saveProduct($product);
    }

    /**
     * Tests that updateProduct updates a product in the database.
     */
    public function testUpdateProduct(): void
    {
        $product = new Products('Updated Product', 'SKU123', 79.99, 'An updated product', 5, 'Category1', 'Category2', 'Category3');
        $product->setId(1);

        $this->updateMock->expects($this->once())
            ->method('update')
            ->with(
                'products',
                [
                    'productName' => $product->getName(),
                    'productSku' => $product->getSku(),
                    'productPrice' => $product->getPrice(),
                    'productDescription' => $product->getDescription(),
                    'productQuantity' => $product->getQuantity()
                ],
                'productID = 1'
            );

        $this->productRepository->updateProduct($product);
    }

    /**
     * Tests that deleteProduct deletes a product from the database.
     */
    public function testDeleteProduct(): void
    {
        $this->deleteMock->expects($this->once())
            ->method('delete')
            ->with('products', 'productID = 1');

        $this->productRepository->deleteProduct(1);
    }

    /**
     * Sets a protected property on an object.
     *
     * @param object $object The object to modify.
     * @param string $property The name of the property to set.
     * @param mixed $value The value to set the property to.
     */
    private function setProtectedProperty(object $object, string $property, $value): void
    {
        $reflection = new \ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }
}
