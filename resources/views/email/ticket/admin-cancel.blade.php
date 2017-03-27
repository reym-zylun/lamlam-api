@extends('email.master')
@section('content')
<b>{{$user->name}}</b> {!! nl2br(trans('custom.cancel_email.admin_body')) !!}<br />
<br />
Reason:
<br />
{{$reason}}
@endsection
