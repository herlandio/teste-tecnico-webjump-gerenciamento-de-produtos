<?php

declare(strict_types=1);

namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use Database\Insert;
use Database\Connection;
use PDO;
use PDOStatement;
use PDOException;

class InsertTest extends TestCase
{
    private Insert $insert;
    private Connection $mockConnection;
    private PDO $mockPDO;
    private PDOStatement $mockStatement;

    protected function setUp(): void
    {
        $this->mockConnection = $this->createMock(Connection::class);
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockStatement = $this->createMock(PDOStatement::class);

        $this->mockConnection->method('getConn')->willReturn($this->mockPDO);

        $this->insert = new Insert();

        $reflectionClass = new \ReflectionClass($this->insert);
        $connectionProperty = $reflectionClass->getProperty('connection');
        $connectionProperty->setAccessible(true);
        $connectionProperty->setValue($this->insert, $this->mockConnection);
    }

    /**
     * Tests the insert method for successful insertion.
     */
    public function testInsertSuccess(): void
    {
        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];

        $this->mockPDO->expects($this->once())->method('beginTransaction');
        $this->mockPDO->expects($this->once())->method('prepare')->willReturn($this->mockStatement);
        $this->mockStatement->expects($this->once())->method('execute')->with(array_values($data));
        $this->mockPDO->expects($this->once())->method('lastInsertId')->willReturn('1');
        $this->mockPDO->expects($this->once())->method('commit');
        $this->mockConnection->expects($this->once())->method('libertyConnection');

        $this->insert->insert('users', $data);
        $this->assertEquals('1', $this->insert->lastId());
    }

    /**
     * Tests the insert method when a PDOException is thrown.
     */
    public function testInsertFailure(): void
    {
        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];

        $this->mockPDO->expects($this->once())->method('beginTransaction');
        $this->mockPDO->expects($this->once())->method('prepare')->willReturn($this->mockStatement);
        $this->mockStatement->expects($this->once())->method('execute')->willThrowException(new PDOException('Erro de inserção'));
        $this->mockPDO->expects($this->once())->method('rollBack');
        $this->mockConnection->expects($this->once())->method('libertyConnection');

        $this->expectOutputString(json_encode([
            "File" => __FILE__,
            "Line" => 64,
            "Message" => 'Erro de inserção',
            "CodeError" => 0
        ]));

        $reflectionClass = new \ReflectionClass($this->insert);
        $lastIDProperty = $reflectionClass->getProperty('lastID');
        $lastIDProperty->setAccessible(true);
        $lastIDProperty->setValue($this->insert, null);

        $this->insert->insert('users', $data);
        $this->assertNull($lastIDProperty->getValue($this->insert));
    }
}
