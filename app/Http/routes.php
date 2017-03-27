<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['before','api','auth:user']], function () {
    // auth routes...
    Route::post('/v1/auth/refresh', [
        'as' => 'auth.refresh',
        'uses' =>  'Auth\AuthController@postRefresh'
    ]);
    // users routes...
    Route::get('/v1/users/{id}/tickets', 'UsersController@getTickets');
    Route::post('/v1/users/{id}/tickets/{user_ticket_id}/cancel', 'UsersController@postCancelTicket');
    Route::get('/v1/users/{id}/tickets/{user_ticket_id}', 'UsersController@getTicketsShow');
    Route::post('/v1/users/{id}/tickets/{user_ticket_id}/split', 'UsersController@postTicketsSplit');
    Route::post('/v1/users/{id}/tickets/{user_ticket_id}/use', 'UsersController@postStartTicket');
    Route::post('/v1/users/{id}/tickets/receive', 'UsersController@postTicketsReceive');
    Route::post('/v1/users/{id}/paymenttoken', 'UsersController@postPaymentToken');

    //User Edit
    Route::match(['get', 'put'],'/v1/users/{id}', array('as'=>'user.editmethod', 'uses'=>'UsersController@UserInformation'));
});

Route::group(['middleware' => ['before','api','auth:admin']], function () {
    // sales summary routes....
    Route::get('/v1/sales_summaries', 'SaleController@getIndex');

    // issued ticket routes....
    Route::get('/v1/issued_tickets', 'IssuedTicketController@getIndex');
    Route::delete('/v1/issued_tickets/{id}', 'IssuedTicketController@deleteDestroy');
    Route::post('/v1/tickets/{ticket_id}/issue', 'IssuedTicketController@postCreate');

    // information routes....
    Route::post('/v1/informations', 'InformationsController@postCreate');
    Route::put('/v1/informations/{id}', 'InformationsController@putEdit');
    Route::delete('/v1/informations/{id}', 'InformationsController@deleteDestroy');

    // ticket routes....
    Route::get('/v1/tickets/{id}/edit', 'TicketsController@getEdit');
    Route::post('/v1/tickets', 'TicketsController@postCreate');
    Route::put('/v1/tickets/{id}/edit', 'TicketsController@putEdit');
    Route::delete('/v1/tickets/{id}', 'TicketsController@deleteDestroy');

    // users routes
    Route::get('/v1/users', 'UsersController@getUsers');

});

Route::group(['middleware' => ['before','api']], function () {
    // auth routes...
    Route::post('/v1/auth/login', 'Auth\AuthController@postLogin');
    Route::post('/v1/password', 'Auth\PasswordController@postReissuePassword');

    //users routes...
    //User Registration
    Route::match(['post'],'/v1/users', array('as'=>'user.regmethod', 'uses'=>'UsersController@UserRegistration'));

    //contact routes...
    //contact sending message
    Route::match(['post'],'/v1/contact', array('as'=>'contact', 'uses'=>'ContactController@postContact'));

    // tickets routes...
    Route::get('/v1/tickets', 'TicketsController@getIndex');
    Route::get('/v1/tickets/{id}', 'TicketsController@getShow');

    //information routes...
    Route::get('/v1/informations', 'InformationsController@getIndex');
    Route::get('/v1/informations/{id}', 'InformationsController@getEdit');

    // payments routes...
    Route::get('/v1/payments/{token}', 'PaymentController@getShow');
    Route::get('/v1/payments/{token}/result', 'PaymentController@getResult');
    Route::post('/v1/payments/{token}', 'PaymentController@postCharge');

    // search routes 
    Route::get('/v1/destinations', 'DestinationController@getIndex');
    Route::get('/v1/courses', 'CourseController@getIndex');
    Route::get('/v1/courses/destinations/{destination_id}', 'CourseController@getToDestination');

    // ad 
    Route::get('/v1/ads',      'AdController@getIndex');
    Route::get('/v1/ads/rand', 'AdController@getRandom');
    Route::get('/v1/ads/{id}', 'AdController@getShow');
});

