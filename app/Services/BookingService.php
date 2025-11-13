<?php

namespace App\Services;

class BookingService
{
    /**
     * @param $ticketQuantity
     * @param $requestedTicketQuantity
     * @return mixed
     */
    public function decrementTicketQuantity($ticketQuantity, $requestedTicketQuantity): int
    {
        return $ticketQuantity - $requestedTicketQuantity;
    }

    /**
     * @param $ticketQuantity
     * @param $requestedTicketQuantity
     * @return int
     */
    public function incrementTicketQuantity($ticketQuantity, $requestedTicketQuantity): int
    {
        return $ticketQuantity + $requestedTicketQuantity;
    }

    /**
     * @param $ticketQuantity
     * @param $requestedTicketQuantity
     * @return bool
     */
    public function checkTicketAvailability($ticketQuantity, $requestedTicketQuantity): bool
    {
        return $ticketQuantity > $requestedTicketQuantity;
    }
}
