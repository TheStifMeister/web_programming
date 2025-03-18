<header class="header-home">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <h1>UniCT Connect</h1>
    </div>

    <div class="search-bar">
        <div class="search-wrapper">
            <input type="text" placeholder="Cerca persone..." id="search-users" data-user-id="{{ Auth::user()->id }}">
            <div id="search-suggestions" class="search-suggestions"></div>
        </div>
    </div>

    <button id="weather-open-btn" class="header-weather-btn" style="margin-left: 15px;"></button>

    <button id="spotify-open-btn" class="header-spotify-btn" style="margin-left: 10px;"></button>

    <div class="user-profile">
        <div class="profile-menu">
            <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('images/default-profile.jpg') }}"
                alt="Profilo" class="profile-pic">
            <span class="username">{{ Auth::user()->name }}</span>
            <span class="arrow-down">▼</span>
        </div>
        <div class="dropdown-content">
            <a href="{{ route('profile.edit') }}">Modifica Profilo</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>
