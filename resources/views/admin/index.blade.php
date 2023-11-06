@extends('layouts.app')

@section('content')
  <div>
    <ul>
        @foreach ($admins as $admin)
            <li>
                <h4>{{$admin->first_name}} {{$admin->last_name}}</h4>
                <h4>{{$admin->role}}</h4>
            </li>
        @endforeach
    </ul>
  </div>
@endsection