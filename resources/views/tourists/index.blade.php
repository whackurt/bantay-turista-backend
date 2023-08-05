@extends('layouts.app')

@section('content')
    <ul>        
        @foreach ($tourists as $tourist)
            <li>
                <h4>{{$tourist->first_name}} {{$tourist->last_name}}</h4>
                <h4>{{$tourist->user->email}}</h4>
            </li>
        @endforeach
    </ul>
@endsection