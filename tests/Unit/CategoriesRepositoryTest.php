<?php

use Database\Delete;
use Database\Insert;
use Database\Select;
use PHPUnit\Framework\TestCase;
use Repositories\CategoriesRepository;

class CategoriesRepositoryTest extends TestCase
{
    private $insertMock;
    private $selectMock;
    private $deleteMock;
    private $categoriesRepository;

    protected function setUp(): void
    {
        $this->insertMock = $this->createMock(Insert::class);
        $this->selectMock = $this->createMock(Select::class);
        $this->deleteMock = $this->createMock(Delete::class);
        $this->categoriesRepository = new CategoriesRepository($this->insertMock, $this->selectMock, $this->deleteMock);
    }

    public function testSaveCategory()
    {
        $data = ['name' => 'New Category'];
        $this->insertMock->expects($this->once())
                         ->method('insert')
                         ->with('categories', $data);

        $this->categoriesRepository->saveCategory($data);
    }

    public function testGetAllCategories()
    {
        $expectedCategories = [
            ['categoryID' => 1, 'name' => 'Category 1'],
            ['categoryID' => 2, 'name' => 'Category 2'],
        ];

        $this->selectMock->expects($this->once())
                         ->method('select')
                         ->with('categories', ['*'])
                         ->willReturn($expectedCategories);

        $categories = $this->categoriesRepository->getAllCategories();

        $this->assertEquals($expectedCategories, $categories);
    }

    public function testDeleteCategoryById()
    {
        $categoryId = 1;

        $this->deleteMock->expects($this->once())
                         ->method('delete')
                         ->with('categories', "categoryID = {$categoryId}");

        $this->categoriesRepository->deleteCategoryById($categoryId);
    }
}
