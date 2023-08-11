@extends('layouts.app')

@section('content')
    <div>
        @foreach ($complaints as $complaint)
            {{-- <strong style="color: brown">{{$complaint}}</strong> --}}
            <h2 style="color: brown">{{$complaint->tourist->last_name}}, {{$complaint->tourist->first_name}} </h2>
            <h3>{{$complaint->tourist->qr_code}}</h3>
            <p>Description: {{$complaint->description}}</p>
            <p>Response: {{$complaint->response}}</p>
            <p style="color: red">Status: {{($complaint->resolved) ? 'Resolved' : 'Pending'}}</p>
            <hr>
        @endforeach
    </div>
@endsection