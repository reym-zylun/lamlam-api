@extends('email.master')
@section('content')
Hello {{$user->name}},<br />
<br />
{!! nl2br(trans('custom.cancel_email.body')) !!}<br />
<br />
Reason:
<br />
{{$reason}}
@endsection
