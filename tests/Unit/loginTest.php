<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class loginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_password_matching()
    {
        $pwd1 = '12345678';
        $pwd2 = '12345678';
    
        $this->assertEquals($pwd1, $pwd2);
        $this->assertGreaterThanOrEqual(8, strlen($pwd1));
        $this->assertLessThanOrEqual(20, strlen($pwd1));
    }

    public function test_password_not_matching()
{
    $pwd1 = '12345678';
    $pwd2 = 'pwd123213';

    $this->assertNotEquals($pwd1, $pwd2);
    $this->assertLessThanOrEqual(20, strlen($pwd1));
    $this->assertGreaterThanOrEqual(8, strlen($pwd1));
    $this->assertLessThanOrEqual(20, strlen($pwd2));
    $this->assertGreaterThanOrEqual(8, strlen($pwd2));
}

public function test_email_matching()
{
    $email = 'test@hotmail.com';

    $this->assertTrue(
        (strpos($email, '@gmail.com') !== false || strpos($email, '@hotmail.com') !== false) &&
        strlen($email) <= 20
    );
}

public function test_email_not_matching()
{
    $email = 'test@12345.com';

    $this->assertTrue(
        !(strpos($email, '@gmail.com') !== false || strpos($email, '@hotmail.com') !== false) &&
        strlen($email) >= 8 && strlen($email) <= 20
    );
}

}
