@extends('layouts.main')

@section('main')

@guest()
    <h1> Masih belum login </h1>
@endguest

    @auth()
        <h1>Sudah login</h1>
    @endauth

@endsection
