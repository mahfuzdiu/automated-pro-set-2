<?php

namespace App\Services;

class PaymentService
{
    /**
     * @param $bookingQuantity
     * @param $ticketPrice
     * @return float|int
     */
    public function calculateTicketPrice($bookingQuantity, $ticketPrice)
    {
        return $bookingQuantity * $ticketPrice;
    }
}
