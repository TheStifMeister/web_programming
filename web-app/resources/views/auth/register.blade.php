@extends('layouts.app')

@section('title', 'Registrati')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <div class="auth-box">
            <h2>Registrati</h2>

            <!-- Errori lato server (Laravel) -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="register-form" action="{{ route('register') }}" method="POST">
                @csrf

                <div>
                    <input type="text" name="name" placeholder="Nome completo">
                    <p class="error-message" style="color:red; display:none;"></p>
                </div>

                <div>
                    <input type="text" name="username" placeholder="Nome utente">
                    <p class="error-message" style="color:red; display:none;"></p>
                </div>

                <div>
                    <input type="email" name="email" placeholder="Email">
                    <p class="error-message" style="color:red; display:none;"></p>
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password">
                    <p class="error-message" style="color:red; display:none;"></p>
                </div>

                <button type="submit">Registrati</button>
            </form>

            <p>Hai già un account? <a href="{{ route('login') }}">Accedi</a></p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const inputs = form.querySelectorAll('input');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    checkField(input);
                });
            });

            form.addEventListener('submit', function(e) {
                let hasError = false;
                inputs.forEach(input => {
                    const error = checkField(input);
                    if (error) hasError = true;
                });
                if (hasError) {
                    e.preventDefault();
                }
            });

            function checkField(input) {
                const val = input.value.trim();
                const errP = input.parentElement.querySelector('.error-message');
                let errorMsg = "";

                if (!val) {
                    errorMsg = "Questo campo è obbligatorio.";
                } else {
                    if (input.name === 'email') {
                        if (!val.includes('@')) {
                            errorMsg = "L'email deve contenere '@'.";
                        }
                    }
                    if (input.name === 'password') {
                        if (val.length < 8) {
                            errorMsg = "La password deve avere almeno 8 caratteri.";
                        }
                    }
                }

                if (errorMsg) {
                    errP.textContent = errorMsg;
                    errP.style.display = "block";
                    return true;
                } else {
                    errP.textContent = "";
                    errP.style.display = "none";
                    return false;
                }
            }
        });
    </script>
@endsection
