@extends('layouts.app')

@section('title', 'Registrati')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <div class="auth-box">
            <h2>Registrati</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nome completo" required>
                <input type="text" name="username" placeholder="Nome utente" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Registrati</button>
            </form>

            <p>Hai già un account? <a href="{{ route('login') }}">Accedi</a></p>
        </div>
    </div>
@endsection
