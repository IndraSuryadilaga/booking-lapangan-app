<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Booking Expiry Time
    |--------------------------------------------------------------------------
    |
    | This value defines the number of minutes a pending booking will remain
    | valid before it automatically expires. This is used to prevent slots
    | from being held indefinitely without payment.
    |
    */
    'expiry_minutes' => 30,

    /*
    |--------------------------------------------------------------------------
    | Booking Slot Duration
    |--------------------------------------------------------------------------
    |
    | This value defines the duration of a single booking slot in minutes.
    | It is used for calculating end times and for display purposes.
    |
    */
    'slot_duration_minutes' => 60,
];
