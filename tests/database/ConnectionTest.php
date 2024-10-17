<?php

declare(strict_types=1);

namespace Tests\Database;

use Config\Config;
use Database\Connection;
use PDO;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    private Connection $connection;
    private PDO $pdoMock;

    protected function setUp(): void
    {
        $configMock = $this->createMock(Config::class);

        $configMock->method('getHost')->willReturn('127.0.0.1');
        $configMock->method('getPort')->willReturn('3306');
        $configMock->method('getDatabase')->willReturn('test_db');
        $configMock->method('getUser')->willReturn('root');
        $configMock->method('getPassword')->willReturn('root');

        $this->pdoMock = $this->createMock(PDO::class);

        $this->connection = new Connection();
    }

    /**
     * Tests that getConn returns a PDO instance.
     */
    public function testGetConnReturnsPdoInstance(): void
    {
        $conn = $this->connection->getConn();
        $this->assertInstanceOf(PDO::class, $conn);
    }

    /**
     * Tests that libertyConnection sets the connection to null.
     */
    public function testLibertyConnectionSetsConnectionToNull(): void
    {
        $this->assertNotNull($this->connection->getConn());

        $this->connection->libertyConnection();
        $reflection = new \ReflectionClass($this->connection);
        $property = $reflection->getProperty('conn');
        $property->setAccessible(true);
        $this->assertNull($property->getValue($this->connection));
    }
}
