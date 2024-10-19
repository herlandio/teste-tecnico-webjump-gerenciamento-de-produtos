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
    /**
     * Tests the getHost method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetHost(): void
    {
        $this->assertSame(base64_decode('ZGItc2VydmljZQ=='), Config::getHost());
    }

    /**
     * Tests the getUser method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetUser(): void
    {
        $this->assertSame(base64_decode('cm9vdA=='), Config::getUser());
    }

    /**
     * Tests the getPassword method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetPassword(): void
    {
        $this->assertSame(base64_decode('cm9vdA=='), Config::getPassword());
    }

    /**
     * Tests the getDatabase method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetDatabase(): void
    {
        $this->assertSame(base64_decode('cHJvZHVjdHM='), Config::getDatabase());
    }

    /**
     * Tests the getPort method of the Config class.
     * Checks if the returned value matches the expected one.
     */
    public function testGetPort(): void
    {
        $this->assertSame(base64_decode('MzMwNg=='), Config::getPort());
    }
}