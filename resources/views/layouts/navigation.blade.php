<nav class="top-nav">
    <div class="content">
        <div class="nav-header">
            <a class="logo" href="@auth {{ route('index') }} @else {{ route('client.form') }} @endauth">
                <img src="{{ asset('storage/img/logo.svg') }}" alt="logo">
                <img src="{{ asset('storage/img/logo-text.svg') }}" alt="logo-text" class="logo-text">
            </a>
            @auth
            <div class="dropdown">
                <a class="dropdown-toggle drop-btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->name }}
                </a>
                <ul class="dropdown-menu">
                    @if(!isset($active))
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Профиль</a></li>
                    @elseif($active == 'profile')
                        <li><a class="dropdown-item" href="{{ route('index') }}">Главная</a></li>
                    @endif
                    <li><a href="{{ route("logout") }}" class="logout dropdown-item">Выйти</a></li>
                </ul>


{{--                    <div class="logout-text blue-text"></div>--}}
{{--                    <img src="{{ asset('storage/img/logout-icon.svg') }}" alt="logout" class="logout-icon">--}}
{{--                </a>--}}
            </div>
            @endauth
        </div>
    </div>
</nav>
