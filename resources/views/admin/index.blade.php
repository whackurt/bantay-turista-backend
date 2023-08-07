@extends('layouts.app')

@section('content')
  <div>
    <ul>
        @foreach ($admins as $admin)
            <li>{{$admin}}</li>
        @endforeach
    </ul>
  </div>
@endsection