<?php

namespace Tests\Unit;

use App\Services\PaymentService;
use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_calculateTicketPrice(): void
    {
        $ps = new PaymentService();
        $actual = $ps->calculateTicketPrice(5, 100);
        $this->assertEquals(500, $actual);
    }
}
