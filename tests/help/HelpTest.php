<?php

declare(strict_types=1);

namespace Tests\Help;

use PHPUnit\Framework\TestCase;
use Help\Help;

/**
 * Class HelpTest
 *
 * Unit tests for the Help class.
 */
final class HelpTest extends TestCase
{
    /**
     * Tests the json method for success response.
     */
    public function testJsonSuccess(): void
    {
        $help = new Help();
        $status = true;
        $message = 'Operation successful';
        $code = 200;

        $expectedJson = json_encode([
            "data" => $status,
            "message" => $message,
            "code" => $code
        ]);

        $this->assertEquals($expectedJson, $help->json($status, $message, $code));
    }

    /**
     * Tests the json method for failure response.
     */
    public function testJsonFailure(): void
    {
        $help = new Help();
        $status = false;
        $message = 'Operation failed';
        $code = 400;

        $expectedJson = json_encode([
            "data" => $status,
            "message" => $message,
            "code" => $code
        ]);

        $this->assertEquals($expectedJson, $help->json($status, $message, $code));
    }
}
