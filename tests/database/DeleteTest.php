<?php

declare(strict_types=1);

namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use Database\Delete;
use Database\Connection;
use PDO;
use PDOException;

class DeleteTest extends TestCase
{
    private Delete $delete;
    private PDO $pdoMock;
    private Connection $connectionMock;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->connectionMock = $this->createMock(Connection::class);
        $this->connectionMock->method('getConn')->willReturn($this->pdoMock);

        $this->delete = new Delete();

        $reflectionClass = new \ReflectionClass($this->delete);
        $connectionProperty = $reflectionClass->getProperty('connection');
        $connectionProperty->setAccessible(true);
        $connectionProperty->setValue($this->delete, $this->connectionMock);
    }

    /**
     * Tests the delete method for successful deletion.
     */
    public function testDeleteSuccess(): void
    {
        $this->pdoMock->expects($this->once())
                      ->method('beginTransaction');

        $this->pdoMock->expects($this->once())
                      ->method('exec')
                      ->with($this->equalTo('DELETE FROM users WHERE id=1'))
                      ->willReturn(true);

        $this->pdoMock->expects($this->once())
                      ->method('commit');

        $this->delete->delete('users', 'id=1');
    }

    /**
     * Tests that an exception is thrown if no where clause is provided.
     */
    public function testDeleteWithoutWhereThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A cláusula WHERE é obrigatória para deletar registros.');

        $this->delete->delete('users');
    }

    /**
     * Tests the delete method when a PDOException is thrown.
     */
    public function testDeleteWithPDOException(): void
    {
        $this->pdoMock->expects($this->once())
                    ->method('beginTransaction');

        $this->pdoMock->expects($this->once())
                    ->method('exec')
                    ->will($this->throwException(new PDOException('Erro ao deletar')));

        $this->pdoMock->expects($this->once())
                    ->method('rollBack');

        ob_start();
        $this->delete->delete('users', 'id=1');
        $output = ob_get_clean();

        $decodedOutput = json_decode($output, true);

        $this->assertSame('Erro ao deletar', $decodedOutput['Message']);
        $this->assertSame(0, $decodedOutput['CodeError']);
    }
}
