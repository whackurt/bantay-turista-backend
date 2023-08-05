@extends('layouts.app')

@section('content')
    <div>
        <p>First Name: <strong>{{ $est->name }}</strong></p>
        <p>Last Na:<strong> {{ $est->owner_name }}</strong></p>
        <p>Contact No.: <strong> {{ $est->contact_number }} </strong></p>
        <p>Type: <strong> {{ $est->type->name }} </strong></p>
    </div>
@endsection