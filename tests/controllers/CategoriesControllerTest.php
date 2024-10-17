<?php

declare(strict_types=1);

namespace Tests\Controllers;

use Controllers\CategoriesController;
use Models\Category;
use Services\CategoriesService;
use PHPUnit\Framework\TestCase;

class CategoriesControllerTest extends TestCase
{
    private CategoriesController $controller;
    private CategoriesService $service;

    protected function setUp(): void
    {
        $this->service = $this->createMock(CategoriesService::class);
        $this->controller = new CategoriesController();

        $reflection = new \ReflectionClass($this->controller);
        $property = $reflection->getProperty('service');
        $property->setAccessible(true);
        $property->setValue($this->controller, $this->service);
    }

    public function testSaveCategoriesSuccessfully(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['newcategory'] = 'Test Category';

        $this->service->expects($this->once())
            ->method('createCategory')
            ->with('Test Category');

        ob_start();
        $this->controller->saveCategories();
        $output = ob_get_clean();

        $expectedOutput = json_encode(['data' => true, 'message' => 'created', 'code' => 201]);
        $this->assertEquals($expectedOutput, $output);
    }

    public function testSaveCategoriesWithInvalidArgumentException(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['newcategory'] = 'Invalid Category';

        $this->service->expects($this->once())
            ->method('createCategory')
            ->with('Invalid Category')
            ->willThrowException(new \InvalidArgumentException('Invalid category'));

        ob_start();
        $this->controller->saveCategories();
        $output = ob_get_clean();

        $expectedOutput = json_encode(['data' => false, 'message' => 'Invalid category', 'code' => 403]);
        $this->assertEquals($expectedOutput, $output);
    }

    public function testListCategoriesSuccessfully(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $mockCategory = $this->createMock(Category::class);
        $mockCategory->method('getCategoryID')->willReturn(1);
        $mockCategory->method('getCategoryName')->willReturn('Test Category');

        $this->service->expects($this->once())
            ->method('listCategories')
            ->willReturn([$mockCategory]);

        $result = $this->controller->listCategories();

        $this->assertCount(1, $result);
        $this->assertEquals(['categoryID' => 1, 'categoryName' => 'Test Category'], $result[0]);
    }

    public function testListCategoriesWithException(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->service->expects($this->once())
            ->method('listCategories')
            ->willThrowException(new \Exception('Error fetching categories'));

        ob_start();
        $result = $this->controller->listCategories();
        $output = ob_get_clean();

        $expectedOutput = json_encode([
            "success" => false,
            "message" => "Erro ao listar categorias: Error fetching categories",
            "code" => 0
        ]);
        $this->assertEmpty($result);
        $this->assertEquals($expectedOutput, $output);
    }

    public function testDeleteCategorySuccessfully(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $id = 1;
    
        $this->service->expects($this->once())
            ->method('deleteCategory')
            ->with($id);
    
        ob_start();
        $this->controller->delete($id);
        $output = ob_get_clean();
    
        $this->assertNotEmpty($output);
        $this->assertStringContainsString('{"success":false,"message":"Erro ao deletar categoria:', $output);
    }
    
    public function testDeleteCategoryWithException(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $id = 1;

        $this->service->expects($this->once())
            ->method('deleteCategory')
            ->with($id)
            ->willThrowException(new \Exception('Error deleting category'));

        ob_start();
        $this->controller->delete($id);
        $output = ob_get_clean();

        $expectedOutput = json_encode([
            "success" => false,
            "message" => "Erro ao deletar categoria: Error deleting category",
            "code" => 0
        ]);
        $this->assertEquals($expectedOutput, $output);
    }
}
