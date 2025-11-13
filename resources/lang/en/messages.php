<?php

return [
    'validation_failed' => 'The given data was invalid, Please try again.',
    'user_created' => 'User has been successfully created, try to log in',
    'invalid_credentials' => 'Invalid credentials, please try again.',
    'logged_out' => 'You have been successfully logged out',
    'no_permission' => 'Access denied. Do not have enough permission',

    'event' => [
        'deleted' => 'Event deleted',
        'not_found' => 'Event not found',
        'cannot_be_deleted' => 'Delete the tickets at first before deleting events',
    ],

    'booking' => [
        'not_found' => 'Booking not found',
        'not_confirmed' => 'Booking is not confirmed yet.',
        'confirmed' => 'Booking is confirmed',
        'exists' => 'You already have an active booking for this ticket.'
    ],

    'ticket' => [
        'deleted' => 'Ticket deleted',
        'not_found' => 'Ticket not found',
        'cannot_be_deleted' => 'Delete the bookings at first before deleting ticket',
        'not_available' => 'Not enough tickets available'
    ],
    'payment' => [
        'success' => 'Payment success',
        'failure' => 'Payment failure',
    ]
];
