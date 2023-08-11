@extends('layouts.app')

@section('content')
    <div>
        @foreach ($logs as $log)
            <strong style="color: brown">{{$log}}</strong>
            <h2 style="color: brown">{{$log->tourist->last_name}}, {{$log->tourist->first_name}} </h2>
            <h3>{{$log->tourist->qr_code}}</h3>
            <p>Establishment: {{$log->establishment->name}}</p>
            <p>Establishment Owner: {{$log->establishment->owner_name}}</p>
            <hr>
        @endforeach
    </div>
@endsection