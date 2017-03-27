@extends('email.master')
@section('content')
{!! trans('thanks_registration.body', [
    'username' => $username,
    'password' => $password,
    'receive_key' => $receive_key,
    'web_link' => $web_link,
    'app_link' => $app_link
]) !!}
@endsection
