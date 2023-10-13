@extends('layouts.app')

@section('content')
    <div>
        <p><strong>Name: {{ $tourist->full_name }}</strong></p>
        <p><strong>Address: {{ $tourist->address }}</strong></p>
        <p><strong>QR Code:</strong></p>
        {!! QrCode::size(300)->generate($tourist->qr_code) !!}
    </div>
@endsection