<!doctype html>
<html lang="en">
<head>
    @include('layouts.head', ['title' => 'Регистрация'])
</head>
<body>
@include('layouts.navigation')
<div class="content">
    <div class="main-content">
        <div class="nav">@include('layouts.nav-panel', ['active' => 'none'])</div>
        @include('layouts.message')
        <script>
            alertMsg('Ошибка', 'danger', 'Страница не найдена', 'white')
        </script>
    </div>

</div>
@include('layouts.footer')
</body>
</html>
