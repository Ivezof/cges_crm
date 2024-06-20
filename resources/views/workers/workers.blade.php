<!doctype html>
<html lang="ru">
<head>
    <script>
        const type = 'workers'
    </script>
    @include('layouts.head', ['title' => 'Платежи'])
</head>
<body>
@include('layouts.navigation')
<div class="content">
    <div class="main-content">
        <div class="nav">@include('layouts.nav-panel', ['active' => 'workers'])</div>
        <div class="client-table">
            @include('layouts.table', ['name' => 'Сотрудники', 'head' => ['ФИО' => ['nofilter'], 'Почта' => ['nofilter']], 'keys' => ['name' => 'edit', 'email' => 'edit']])
        </div>
    </div>

</div>
@include('layouts.footer')
</body>
</html>
