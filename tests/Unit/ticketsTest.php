<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ticketsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_buyTickets_correct()
    {
        // Create a scenario where there is enough space for ticket purchase
        $maxUsers = 100;
        $usersRegistered = 80;
        $numTicketsWanted = 5;

        $this->assertTrue(
            $this->canUserBuyTickets($maxUsers, $usersRegistered, $numTicketsWanted)
        );
    }

    public function test_buyTickets_incorrect()
    {
        // Create a scenario where there is insufficient space for ticket purchase
        $maxUsers = 100;
        $usersRegistered = 95; // Only 5 spots available
        $numTicketsWanted = 10;

        $this->assertFalse(
            $this->canUserBuyTickets($maxUsers, $usersRegistered, $numTicketsWanted)
        );
    }

    public function test_buy_zero_tickets()
    {
        // Create a scenario where a user is trying to buy zero tickets
        $maxUsers = 100;
        $usersRegistered = 80;
        $numTicketsWanted = 0;

        $this->assertFalse(
            $this->canUserBuyTickets($maxUsers, $usersRegistered, $numTicketsWanted)
        );
    }

    private function canUserBuyTickets($maxUsers, $usersRegistered, $numTicketsWanted)
    {
        $remainingSpace = $maxUsers - $usersRegistered;

        return $remainingSpace >= $numTicketsWanted && $numTicketsWanted > 0;
    }
}
