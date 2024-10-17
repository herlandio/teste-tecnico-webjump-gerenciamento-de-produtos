<?php

declare(strict_types=1);

namespace Tests\Repositories;

use PHPUnit\Framework\TestCase;
use Repositories\CategoriesRepository;
use Database\Insert;
use Database\Select;
use Database\Delete;

class CategoriesRepositoryTest extends TestCase
{
    private CategoriesRepository $repository;
    private Insert $insertMock;
    private Select $selectMock;
    private Delete $deleteMock;

    protected function setUp(): void
    {
        $this->insertMock = $this->createMock(Insert::class);
        $this->selectMock = $this->createMock(Select::class);
        $this->deleteMock = $this->createMock(Delete::class);

        $this->repository = new CategoriesRepository();

        $reflection = new \ReflectionClass($this->repository);
        $insertProperty = $reflection->getProperty('insert');
        $insertProperty->setAccessible(true);
        $insertProperty->setValue($this->repository, $this->insertMock);

        $selectProperty = $reflection->getProperty('select');
        $selectProperty->setAccessible(true);
        $selectProperty->setValue($this->repository, $this->selectMock);

        $deleteProperty = $reflection->getProperty('delete');
        $deleteProperty->setAccessible(true);
        $deleteProperty->setValue($this->repository, $this->deleteMock);
    }

    /**
     * Tests that saveCategory calls the insert method.
     */
    public function testSaveCategoryCallsInsert(): void
    {
        $data = ['name' => 'Test Category'];

        $this->insertMock->expects($this->once())
            ->method('insert')
            ->with('categories', $data);

        $this->repository->saveCategory($data);
    }

    /**
     * Tests that getAllCategories returns an array of categories.
     */
    public function testGetAllCategoriesReturnsArray(): void
    {
        $expectedCategories = [['categoryID' => 1, 'name' => 'Test Category']];

        $this->selectMock->expects($this->once())
            ->method('select')
            ->with('categories', ['*'])
            ->willReturn($expectedCategories);

        $categories = $this->repository->getAllCategories();

        $this->assertSame($expectedCategories, $categories);
    }

    /**
     * Tests that deleteCategoryById calls the delete method.
     */
    public function testDeleteCategoryByIdCallsDelete(): void
    {
        $categoryId = 1;

        $this->deleteMock->expects($this->once())
            ->method('delete')
            ->with('categories', "categoryID = {$categoryId}");

        $this->repository->deleteCategoryById($categoryId);
    }
}
