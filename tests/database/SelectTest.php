<?php

declare(strict_types=1);

namespace Tests\Database;

use Database\Select;
use Database\Connection;
use PDO;
use PDOStatement;
use PDOException;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    private Select $select;
    private Connection $mockConnection;
    private PDOStatement $mockStatement;

    protected function setUp(): void
    {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockStatement = $this->createMock(PDOStatement::class);

        $this->mockConnection->method('getConn')->willReturn($this->mockPDO);

        $this->select = new Select();

        $reflection = new \ReflectionClass($this->select);
        $connectionProperty = $reflection->getProperty('connection');
        $connectionProperty->setAccessible(true);
        $connectionProperty->setValue($this->select, $this->mockConnection);

        $this->mockPDO->method('prepare')->willReturn($this->mockStatement);
    }

    /**
     * Tests the select method returns expected data.
     */
    public function testSelectReturnsData(): void
    {
        $expectedData = [
            ['id' => 1, 'name' => 'User One'],
            ['id' => 2, 'name' => 'User Two'],
        ];

        $this->mockStatement->method('fetchAll')->willReturn($expectedData);

        $result = $this->select->select('users', ['id', 'name']);

        $this->assertEquals($expectedData, $result);
    }

    /**
     * Tests the select method throws exception on empty fields.
     */
    public function testSelectThrowsExceptionOnEmptyFields()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Os campos para selecionar não podem estar vazios.");

        $this->select->select('users', []);
    }

    /**
     * Tests the select method handles PDOException.
     */
    public function testSelectHandlesPDOException(): void
    {
        $fields = ['id', 'name'];
        $table = 'users';

        $this->mockStatement->method('execute')->willThrowException(new \PDOException("Table does not exist"));

        ob_start();
        $result = $this->select->select($table, $fields);
        $output = ob_get_clean();

        $expectedJson = json_encode([
            "File" => "/var/www/html/tests/database/SelectTest.php",
            "Line" => 74,
            "Message" => "Table does not exist",
            "CodeError" => 0
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, $output);
        $this->assertEmpty($result);
    }

    /**
     * Tests the select method handles empty result.
     */
    public function testSelectHandlesEmptyResult(): void
    {
        $fields = ['id', 'name'];
        $table = 'users';

        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('fetchAll')->willReturn([]);

        $result = $this->select->select($table, $fields);

        $this->assertCount(0, $result);
    }

    /**
     * Tests the select method handles WHERE clause.
     */
    public function testSelectHandlesWhereClause(): void
    {
        $fields = ['id', 'name'];
        $table = 'users';
        $where = 'id = 1';
        $mockData = [['id' => 1, 'name' => 'Alice']];

        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('fetchAll')->willReturn($mockData);

        $result = $this->select->select($table, $fields, $where);

        $this->assertCount(1, $result);
        $this->assertEquals($mockData, $result);
    }
}
