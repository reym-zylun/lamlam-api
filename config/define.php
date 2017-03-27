
<?php
return 
[
   'token_time' => [
        'access' => [
            'days'                  => 0,
            'hours'                 => 0,
            'minutes'               => 1
        ],
        'refresh' => [
            'days'                  => 0,
            'hours'                 => 1,
            'minutes'               => 0
        ],
        'payment' => [
            'days'                  => 0,
            'hours'                 => 0,
            'minutes'               => 10
        ]
    ],

    'ticket_type' => [
        'day'                   => 'day',
        'time'                  => 'time',
    ],
    'valid' => [
        'true'                  => 1,
        'false'                 => 0
    ],
    'result' => [
        'success'               => 'success',
        'failure'               => 'failure',
    ],
    'authorize' => [
        'result_code' => [
            'ok'                => 'OK',
            'error'             => 'ERROR'
        ],
        'response_code' => [
            'approved'          => 1,
            'declined'          => 2,
            'error'             => 3,
            'held_for_review'   => 4
        ]
    ],
    'user_registration'    => [
        'ticket_id' => 4,
        'adult_num' => 1,
        'child_num' => 0
    ]
];
