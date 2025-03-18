@extends('layouts.app')

@section('title', 'Profilo di ' . $user->name)

@section('style')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection


@section('content')
    <div class="profile-container">
        <h1>Profilo di {{ $user->name }}</h1>

        <div class="profile-info">
            <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('images/default-profile.jpg') }}"
                alt="Foto Profilo" class="profile-pic">

            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary">Torna alla Home</a>
    </div>
@endsection
