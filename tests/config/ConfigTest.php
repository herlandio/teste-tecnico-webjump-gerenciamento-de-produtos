<?php

declare(strict_types=1);

namespace Tests\Config;

use PHPUnit\Framework\TestCase;
use Config\Config;

/**
 * Class ConfigTest
 *
 * Unit tests for the Config class. Each method verifies if
 * the methods of the Config class return the correct values
 * from environment variables.
 */
final class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('MYSQL_DB_HOST=localhost');
        putenv('MYSQL_DB_USER=root');
        putenv('MYSQL_ROOT_PASSWORD=secret');
        putenv('MYSQL_DATABASE=test_db');
        putenv('MYSQL_DB_PORT=3306');
    }

    /**
     * Tests the getHost method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetHost(): void
    {
        $this->assertSame('localhost', Config::getHost());
    }

    /**
     * Tests the getUser method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetUser(): void
    {
        $this->assertSame('root', Config::getUser());
    }

    /**
     * Tests the getPassword method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetPassword(): void
    {
        $this->assertSame('secret', Config::getPassword());
    }

    /**
     * Tests the getDatabase method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetDatabase(): void
    {
        $this->assertSame('test_db', Config::getDatabase());
    }

    /**
     * Tests the getPort method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetPort(): void
    {
        $this->assertSame('3306', Config::getPort());
    }

    protected function tearDown(): void
    {
        putenv('MYSQL_DB_HOST');
        putenv('MYSQL_DB_USER');
        putenv('MYSQL_ROOT_PASSWORD');
        putenv('MYSQL_DATABASE');
        putenv('MYSQL_DB_PORT');
    }
}
