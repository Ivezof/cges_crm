<!doctype html>
<html lang="ru">
<head>
    @include('layouts.head', ['title' => 'Меню'])
</head>
<body>
    @include('layouts.navigation')
    <div class="content">
        @include('layouts.nav-panel')
    </div>
    @include('layouts.footer')
</body>
</html>
