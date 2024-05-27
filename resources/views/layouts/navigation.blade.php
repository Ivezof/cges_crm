<nav class="top-nav">
    <div class="content">
        <div class="nav-header">
            <a class="logo" href="{{ route('index') }}">
                <img src="{{ asset('storage/img/logo.svg') }}" alt="logo">
                <img src="{{ asset('storage/img/logo-text.svg') }}" alt="logo-text" class="logo-text">
            </a>

            <a href="{{ route("logout") }}" class="logout">
                <div class="logout-text blue-text">Выйти</div>
                <img src="{{ asset('storage/img/logout-icon.svg') }}" alt="logout" class="logout-icon">
            </a>
        </div>
    </div>
</nav>
