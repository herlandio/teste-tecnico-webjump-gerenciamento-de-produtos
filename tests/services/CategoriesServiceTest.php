<?php

declare(strict_types=1);

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use Services\CategoriesService;
use Repositories\CategoriesRepository;
use Models\Category;
use ReflectionClass;

class CategoriesServiceTest extends TestCase
{
    private CategoriesService $categoriesService;
    private CategoriesRepository $categoriesRepositoryMock;

    protected function setUp(): void
    {
        $this->categoriesRepositoryMock = $this->createMock(CategoriesRepository::class);

        $this->categoriesService = new CategoriesService();
        $reflection = new ReflectionClass($this->categoriesService);
        $property = $reflection->getProperty('repository');
        $property->setAccessible(true);
        $property->setValue($this->categoriesService, $this->categoriesRepositoryMock);
    }

    /**
     * Tests that createCategory successfully saves a category.
     */
    public function testCreateCategorySuccess(): void
    {
        $categoryName = 'Books';

        $this->categoriesRepositoryMock->expects($this->once())
            ->method('saveCategory')
            ->with($this->equalTo(['categoryName' => $categoryName]));

        $this->categoriesService->createCategory($categoryName);
    }

    /**
     * Tests that createCategory throws an exception for an empty name.
     */
    public function testCreateCategoryEmptyNameThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome da categoria não pode estar vazio.');

        $this->categoriesService->createCategory('');
    }

    /**
     * Tests that listCategories returns a list of categories.
     */
    public function testListCategoriesSuccess(): void
    {
        $mockedCategories = [
            ['categoryID' => 1, 'categoryName' => 'Books'],
            ['categoryID' => 2, 'categoryName' => 'Movies']
        ];

        $this->categoriesRepositoryMock->expects($this->once())
            ->method('getAllCategories')
            ->willReturn($mockedCategories);

        $categories = $this->categoriesService->listCategories();

        $this->assertCount(2, $categories);
        $this->assertInstanceOf(Category::class, $categories[0]);
        $this->assertEquals('Books', $categories[0]->getCategoryName());
        $this->assertEquals(1, $categories[0]->getCategoryID());
    }

    /**
     * Tests that deleteCategory successfully deletes a category by ID.
     */
    public function testDeleteCategorySuccess(): void
    {
        $categoryId = 1;

        $this->categoriesRepositoryMock->expects($this->once())
            ->method('deleteCategoryById')
            ->with($this->equalTo($categoryId));

        $this->categoriesService->deleteCategory($categoryId);
    }
}
