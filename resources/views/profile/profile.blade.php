<!doctype html>
<html lang="ru">
<head>
    @include('layouts.head', ['title' => 'Профиль'])
</head>
<body>
    @include('layouts.navigation', ['active' => 'profile'])
    <div class="content">
    {{--        // TODO доделать профиль хотя б немного --}}
        <h1>Добро пожаловать, {{ auth()->user()->name }}</h1>
    </div>
    @include('layouts.footer')
</body>
</html>
