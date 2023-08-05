@extends('layouts.app')

@section('content')
  <div>
    <p>First Name: <strong>{{ $tourist->first_name }}</strong></p>
    <p>Last Name: <strong> {{ $tourist->last_name }}</strong></p>
    <p>Email: <strong> {{ $tourist->user->email }} </strong></p>
  </div>
@endsection