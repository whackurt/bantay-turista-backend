@extends('layouts.app')

@section('content')
    <div>
        <p><strong>{{ $est->name }}</strong></p>
        <p><strong> {{ $est->address }}</strong></p>
        <p><strong> {{ $est->photo_url }}</strong></p>
    </div>
    @for ($i = 0;  $i < (count($tourists) < 5 ? count($tourists) : 5);  $i++)
        <ul>
            <p><strong>{{ $tourists[$i] }}</strong></p>
            <p><strong>{{ $timestamps[$i] }}</strong></p>
        </ul>
    @endfor
@endsection