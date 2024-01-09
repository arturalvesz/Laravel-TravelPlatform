<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private const VALID_PASSWORD = '12345678';
    private const INVALID_PASSWORD = 'pwd123213';
    private const VALID_EMAIL = 'test@hotmail.com';
    private const INVALID_EMAIL = 'test@12345.com';

    /**
     * Test for password matching.
     */
    public function testPasswordMatching()
    {
        $this->assertEquals(self::VALID_PASSWORD, self::VALID_PASSWORD);
        $this->assertGreaterThanOrEqual(8, strlen(self::VALID_PASSWORD));
        $this->assertLessThanOrEqual(20, strlen(self::VALID_PASSWORD));
    }

    /**
     * Test for password not matching.
     */
    public function testPasswordNotMatching()
    {
        $this->assertNotEquals(self::VALID_PASSWORD, self::INVALID_PASSWORD);
        $this->assertLessThanOrEqual(20, strlen(self::VALID_PASSWORD));
        $this->assertGreaterThanOrEqual(8, strlen(self::VALID_PASSWORD));
        $this->assertLessThanOrEqual(20, strlen(self::INVALID_PASSWORD));
        $this->assertGreaterThanOrEqual(8, strlen(self::INVALID_PASSWORD));
    }

    /**
     * Test for email matching.
     */
    public function testEmailMatching()
    {
        $this->assertTrue(
            filter_var(self::VALID_EMAIL, FILTER_VALIDATE_EMAIL) !== false &&
            strlen(self::VALID_EMAIL) <= 255
        );
    }

    /**
     * Test for email not matching.
     */
    public function testEmailNotMatching()
    {
        $this->assertFalse(
            filter_var(self::INVALID_EMAIL, FILTER_VALIDATE_EMAIL) !== false &&
            strlen(self::INVALID_EMAIL) >= 8 && strlen(self::INVALID_EMAIL) <= 255
        );
    }
}