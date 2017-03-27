@extends('email.master')
@section('content')
Hello {{$username}},<br />
<br />
You have requested a new password. Please click the following link to activate <br />
<br />
New Password: {{$password}}<br />
<br />
<a href="{{$link}}">Login Page</a>
@endsection
