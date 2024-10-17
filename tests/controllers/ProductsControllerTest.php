<?php

declare(strict_types=1);

namespace Tests\Controllers;

use Controllers\ProductsController;
use Services\ProductService;
use Help\Help;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Exception;

class ProductsControllerTest extends TestCase
{
    private ProductsController $controller;
    private ProductService $service;

    protected function setUp(): void
    {
        $this->service = $this->createMock(ProductService::class);
        $this->controller = new ProductsController();
        
        $reflection = new ReflectionClass($this->controller);
        $serviceProperty = $reflection->getProperty('service');
        $serviceProperty->setAccessible(true);
        $serviceProperty->setValue($this->controller, $this->service);
    }

    /**
     * Tests saving a product successfully.
     */
    public function testSaveProductSuccess(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'Test Product',
            'sku' => 'TEST123',
            'price' => 100,
            'description' => 'Test description',
            'quantity' => 10,
            'categoryOne' => 'Category 1',
            'categoryTwo' => 'Category 2',
            'categoryThree' => 'Category 3'
        ];

        $this->service->expects($this->once())
                      ->method('saveProduct')
                      ->with($_POST);

        ob_start();
        $this->controller->save();
        $output = ob_get_clean();

        $expectedOutput = (new Help())->json(true, "Produto criado com sucesso.", 201);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * Tests saving a product with validation failure.
     */
    public function testSaveProductFailure(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'Test Product',
        ];

        $this->service->expects($this->once())
                      ->method('saveProduct')
                      ->will($this->throwException(new Exception("Erro de validação", 400)));

        ob_start();
        $this->controller->save();
        $output = ob_get_clean();

        $expectedOutput = json_encode([
            "success" => false,
            "message" => "Erro ao salvar produto: Erro de validação",
            "code" => 400
        ]);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * Tests updating a product successfully.
     */
    public function testUpdateProductSuccess(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'id' => 1,
            'name' => 'Updated Product',
        ];

        $this->service->expects($this->once())
                      ->method('updateProduct')
                      ->with($_POST);

        ob_start();
        $this->controller->update();
        $output = ob_get_clean();

        $expectedOutput = (new Help())->json(true, "Produto atualizado com sucesso.", 200);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * Tests updating a product with an error.
     */
    public function testUpdateProductFailure(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'id' => 1,
            'name' => 'Updated Product',
        ];

        $this->service->expects($this->once())
                      ->method('updateProduct')
                      ->will($this->throwException(new Exception("Erro ao atualizar", 400)));

        ob_start();
        $this->controller->update();
        $output = ob_get_clean();

        $expectedOutput = json_encode([
            "success" => false,
            "message" => "Erro ao atualizar produto: Erro ao atualizar",
            "code" => 400
        ]);

        $this->assertSame($expectedOutput, $output);
    }

    /**
     * Tests deleting a product successfully.
     */
    public function testDeleteProductSuccessful(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $productId = 1;

        $this->service->expects($this->once())
                      ->method('deleteProduct')
                      ->with($productId);

        ob_start();
        $this->controller->delete($productId);
        ob_end_clean();
    }

    /**
     * Tests deleting a product with an exception.
     */
    public function testDeleteProductWithException(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $productId = 1;

        $this->service->expects($this->once())
                      ->method('deleteProduct')
                      ->with($productId)
                      ->will($this->throwException(new Exception('Erro de teste')));

        ob_start();
        $this->controller->delete($productId);
        $output = ob_get_clean();

        $this->assertStringContainsString('Erro ao excluir produto: Erro de teste', $output);
    }

    /**
     * Tests listing products successfully.
     */
    public function testListProductsSuccess(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $this->service->expects($this->once())
                      ->method('listProducts')
                      ->willReturn([]);

        $products = $this->controller->listProducts();
        
        $this->assertIsArray($products);
    }

    /**
     * Tests listing products with an exception.
     */
    public function testListProductsFailure(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->service->expects($this->once())
                      ->method('listProducts')
                      ->will($this->throwException(new Exception("Erro ao listar produtos", 500)));

        ob_start();
        $products = $this->controller->listProducts();
        $output = ob_get_clean();

        $expectedOutput = json_encode([
            "success" => false,
            "message" => "Erro ao listar produtos: Erro ao listar produtos",
            "code" => 500
        ]);

        $this->assertSame($expectedOutput, $output);
        $this->assertEmpty($products);
    }
}
