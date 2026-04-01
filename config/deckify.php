<?php

return [
    'plan_limits' => [
        'free' => (int) env('DECKIFY_LIMIT_FREE', 5),
        'pro' => (int) env('DECKIFY_LIMIT_PRO', 30),
        'team' => (int) env('DECKIFY_LIMIT_TEAM', 100),
    ],
];
