@extends('layouts.app')

@section('content')
    <div>
        <p>Establishment Name: <strong>{{ $est->name }}</strong></p>
        <p>Owner Name:<strong> {{ $est->owner_name }}</strong></p>
        <p>Contact No.: <strong> {{ $est->contact_number }} </strong></p>
        <p>Type: <strong> {{ $est->type->name }} </strong></p>
    </div>
@endsection