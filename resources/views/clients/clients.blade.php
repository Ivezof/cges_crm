<!doctype html>
<html lang="ru">
<head>
    <script>
        const type = 'client'
    </script>
    @include('layouts.head', ['title' => 'Клиенты'])
</head>
<body>
    @include('layouts.navigation')
    <div class="content">
        <div class="main-content">
            <div class="nav">@include('layouts.nav-panel', ['active' => 'clients'])</div>
            <div class="client-table">
                @include('layouts.table', ['name' => 'Клиенты', 'head' => ['ФИО' => ['nofilter'], 'Почта' => ['nofilter'], 'Номер телефона' => ['nofilter'], 'Телеграм' => ['nofilter'], 'Активные заказы' => ['filter', 'orders_count']], 'keys' => ['fio' => 'edit', 'email' => 'edit', 'phone' => 'edit', 'telegram' => 'edit', 'orders_count' => 'no_edit']])
            </div>
        </div>

    </div>
    @include('layouts.footer')
</body>
</html>
