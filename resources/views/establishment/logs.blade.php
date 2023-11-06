@extends('layouts.app')

@section('content')
    @for ($i = 0;  $i < count($tourists);  $i++)
        <ul>
            <p><strong>{{ $tourists[$i] }}</strong></p>
            <p><strong>{{ $date[$i] }} {{ $time[$i] }}</strong></p>
        </ul>
    @endfor
@endsection