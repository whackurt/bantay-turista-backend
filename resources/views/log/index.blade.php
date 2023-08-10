@extends('layouts.app')

@section('content')
    <div>
        <p>{{$log}}</p>
        <p>{{$log[0]->tourist->first_name}} {{$log[0]->tourist->last_name}}</p>
        <p>{{$log[0]->establishment->name}}</p>
        <p>{{$log[0]->establishment->owner_name}}</p>
    </div>
@endsection