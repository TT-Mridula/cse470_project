<?php

return [
    'ttl_minutes' => (int) env('OTP_TTL_MINUTES', 10),
    'length'      => (int) env('OTP_LENGTH', 6),
];