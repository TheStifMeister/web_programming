@extends('layouts.app')

@section('title', 'Home')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">Benvenuto, {{ Auth::user()->name }}!</h1>

        <div class="create-post-trigger" id="openPostModal">
            <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('images/default-profile.jpg') }}"
                alt="Profilo" class="profile-pic">
            <span>A cosa stai pensando, {{ Auth::user()->name }}?</span>
        </div>

        <div class="modal" id="postModal">
            <div class="modal-content">
                <span class="close-modal" id="closePostModal">&times;</span>
                <h3>Crea un nuovo post</h3>
                <form action="{{ route('post.store') }}" method="POST">
                    @csrf
                    <textarea name="content" placeholder="Scrivi il tuo post qui..." required></textarea>
                    <button type="submit" class="btn">Pubblica</button>
                </form>
            </div>
        </div>
        <div class="posts">
            <h3>Post recenti</h3>
            @foreach ($posts as $post)
                <div class="post">
                    <div class="post-header">
                        <img src="{{ $post->user->profile_pic ? asset('storage/' . $post->user->profile_pic) : asset('images/default-profile.jpg') }}"
                            alt="Profilo" class="profile-pic">
                        <div>
                            <strong>{{ $post->user->name }}</strong>
                            <small>{{ $post->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    <p>{{ $post->content }}</p>
                    <div class="post-actions">
                        <form action="{{ route('post.like', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="like-btn">
                                @if ($post->likes->where('user_id', Auth::id())->count())
                                    ❤️ Rimuovi Mi Piace
                                @else
                                    ❤️ Mi Piace
                                @endif
                            </button>
                        </form>
                        <span>{{ $post->likes->count() }} like</span>
                    </div>

                    <div class="comments-section">

                        <form action="{{ route('post.comment', $post->id) }}" method="POST">
                            @csrf
                            <div class="comment-input">
                                <textarea name="content" placeholder="Scrivi un commento..." required></textarea>
                                <button type="submit" class="comment-submit"></button>
                            </div>
                        </form>

                        <div class="comments-list">
                            @foreach ($post->comments as $comment)
                                <div class="comment">
                                    <img class="profile-pic"
                                        src="{{ $comment->user->profile_pic ? asset('storage/' . $comment->user->profile_pic) : asset('images/default-profile.jpg') }}"
                                        alt="Foto Profilo">
                                    <div class="comment-content">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <p>{{ $comment->content }}</p>
                                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @include('partials.weather')
        @include('partials.spotify')
    </div>
@endsection

@section('scripts')
    <script>
        function autoResize(textarea) {
            textarea.style.height = "40px";
            textarea.style.height = (textarea.scrollHeight) + "px";
        }
    </script>
@endsection
