<?php

declare(strict_types=1);

namespace Tests\Database;

use Database\Update;
use Database\Connection;
use PDO;
use PDOException;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class UpdateTest extends TestCase
{
    private Update $update;
    private Connection $mockConnection;
    private PDO $mockPDO;
    private PDOStatement $mockStatement;

    protected function setUp(): void
    {
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockConnection = $this->createMock(Connection::class);
        $this->mockStatement = $this->createMock(PDOStatement::class);

        $this->mockConnection->method('getConn')->willReturn($this->mockPDO);
        $this->mockPDO->method('prepare')->willReturn($this->mockStatement);

        $this->update = new Update();

        $reflection = new \ReflectionClass($this->update);
        $connectionProperty = $reflection->getProperty('connection');
        $connectionProperty->setAccessible(true);
        $connectionProperty->setValue($this->update, $this->mockConnection);
    }

    /**
     * Tests the update method for successful updates.
     */
    public function testUpdateSuccessful(): void
    {
        $table = 'users';
        $campos = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $where = 'id = 1';

        $this->mockStatement->method('execute')->willReturn(true);
        $this->mockStatement->method('rowCount')->willReturn(1);

        $this->update->update($table, $campos, $where);

        $this->assertEquals(1, $this->update->countChange());
    }

    /**
     * Tests the update method throws an exception on empty WHERE clause.
     */
    public function testUpdateThrowsExceptionOnEmptyWhere(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("A cláusula WHERE é obrigatória para atualizar registros.");

        $this->update->update('users', ['name' => 'John Doe'], '');
    }

    /**
     * Tests the update method handles PDOException.
     */
    public function testUpdateHandlesPDOException(): void
    {
        $table = 'users';
        $campos = ['name' => 'John Doe'];
        $where = 'id = 1';

        $this->mockStatement->method('execute')->willThrowException(new PDOException("Table does not exist"));

        ob_start();
        $this->update->update($table, $campos, $where);
        $output = ob_get_clean();

        $expectedJson = json_encode([
            "File" => "/var/www/html/tests/database/UpdateTest.php",
            "Line" => 75,
            "Message" => "Table does not exist",
            "CodeError" => 0
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, $output);
    }
}
