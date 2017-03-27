@extends('email.master')
@section('content')
{!! trans('contact_complete.body', [
    'username' => $input->name,
    'email' => $input->email,
    'message' => nl2br(htmlspecialchars($input->message ,ENT_QUOTES))
]) !!}
@endsection
