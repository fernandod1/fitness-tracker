<?php

return [
    'rateLimiting' => env('API_RATE_LIMITING', 60),
    'blockedIps' => env('API_BLOCKED_IPS', ['10.20.30.40', '::2'])
];