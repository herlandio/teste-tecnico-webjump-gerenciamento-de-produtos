<?php

declare(strict_types=1);

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use Models\Category;

/**
 * Class CategoryTest
 *
 * Unit tests for the Category class.
 */
final class CategoryTest extends TestCase
{
    /**
     * Tests the constructor and the getters.
     */
    public function testConstructorAndGetters(): void
    {
        $category = new Category("Electronics", 1);

        $this->assertEquals(1, $category->getCategoryID());
        $this->assertEquals("Electronics", $category->getCategoryName());
    }

    /**
     * Tests the setCategoryID method.
     */
    public function testSetCategoryID(): void
    {
        $category = new Category("Books");
        $category->setCategoryID(2);

        $this->assertEquals(2, $category->getCategoryID());
    }

    /**
     * Tests the setCategoryName method.
     */
    public function testSetCategoryName(): void
    {
        $category = new Category("Toys");
        $category->setCategoryName("Games");

        $this->assertEquals("Games", $category->getCategoryName());
    }

    /**
     * Tests category ID being null.
     */
    public function testCategoryIDNullable(): void
    {
        $category = new Category("Food", null);

        $this->assertNull($category->getCategoryID());
    }
}
