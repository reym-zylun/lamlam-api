@extends('email.master')
@section('content')
There was contact us.<br />
<br />
Customer Name: {{$input->name}}<br />
Customer Email: {{$input->email}}<br />
Customer Message: <br />
{!! nl2br(htmlspecialchars($input->message ,ENT_QUOTES)) !!}<br />
<br />
Please reply.
@endsection
