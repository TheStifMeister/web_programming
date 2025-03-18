@extends('layouts.app')

@section('title', 'Accedi')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <div class="auth-box">
            <h2>Accedi</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="text" name="username" placeholder="Nome utente" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Accedi</button>
            </form>

            <p>Non hai un account? <a href="{{ route('register') }}">Registrati</a></p>
        </div>
    </div>
@endsection
