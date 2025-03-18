@extends('layouts.app')

@section('title', 'Modifica Profilo')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection


@section('content')

    <div class="profile-container">
        <h1>Modifica Profilo</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="profile-info">
            <div class="profile-pic-wrapper">
                @if ($user->profile_pic)
                    <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Profilo">
                @else
                    <img src="https://i.pinimg.com/564x/29/b8/d2/29b8d250380266eb04be05fe21ef19a7.jpg"
                        alt="Profilo Predefinito">
                @endif
            </div>
            <p>{{ $user->name }}</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="profile_pic">Cambia Immagine Profilo:</label>
                <input type="file" name="profile_pic" id="profile_pic">
                @error('profile_pic')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn">Aggiorna Profilo</button>
        </form>

        <a href="{{ route('home') }}" class="btn btn-secondary" style="margin-top: 20px;">Torna alla Home</a>
    </div>
@endsection
