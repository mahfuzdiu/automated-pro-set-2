<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ExistingBookingException extends Exception
{
    public function __construct(
        ?string $message = null,
        int $code = Response::HTTP_BAD_REQUEST
    ) {
        parent::__construct($message ?? __('messages.booking.exists'), $code);
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
