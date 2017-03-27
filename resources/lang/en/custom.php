<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Language Lines
    |--------------------------------------------------------------------------
    | custom API languaege texts.
    | 
    | 
    | 
    |
    */

    'success'                   => '成功',
    'failure'                   => '失敗',
    'errors' => [
        'occurred'              => 'Occurred Error.', 
        'db'                    => 'Occurred DB Error.',
        'auth'                  => 'Authentication Error.',
        'validation'            => 'Validation Error.',
        'token_expired'         => 'Token Expired.',
        'not_registered'        => 'Not Registered.',
        'not_found'             => 'Not Found.',
        'ticket_already_used'   => 'This ticket is already used.',
        'ticket_already_expired'=> 'This ticket is already expired.',
        'conflict'              => 'Data already exists.',
        'expired'               => 'Enable expired.',
    ],
    'contact' => [
        'complete'              => 'Contact reception completion',
        'received'              => 'There was a contact',
    ], 
    'authorize' => [
        'api' => [
            'E00003'            => 'The card information is incorrect.',
            'E00013'            => 'Payment Profile information is invalid.Please contact from the inquiry form.',
            'E00027'            => 'The transaction was unsuccessful.'
        ],
        'tran' => [
            '6'                 => 'The credit card number is invalid.',
            '7'                 => 'Credit card expiration date is invalid.',
            '11'                => 'A duplicate transaction has been submitted.',
            '54'                => 'It can not be canceled within 24 hours after the settlement. Please try again after 24 hours.',
        ],
    ],
    'cancel_email'    => [
        'body'                  => 'Your ticket has been successfully cancelled.',
        'admin_body'            => 'has cancelled a ticket.',
        'subject'               => 'Ticket cancel completion'
    ],
    'cancel_ticket_used'        => 'This ticket is already used.',
    'cancel_ticket_cancelled'   => 'This ticket is already canceled.',
    'cancel_ticket_splitted'    => 'This ticket is already splitted.',
    'cancel_ticket_no_possible' => 'This ticket is not possible to cancel.',
];
