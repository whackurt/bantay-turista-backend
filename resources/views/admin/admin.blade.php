@extends('layouts.app')

@section('content')
  <div>
    <p>First Name: <strong>{{ $admin->first_name }}</strong></p>
    <p>Last Name: <strong> {{ $admin->last_name }}</strong></p>
    <p>Email: <strong> {{ $admin->user->email }} </strong></p>
  </div>
@endsection