<!doctype html>
<html lang="ru">
<head>
    <script>
        const type = 'payments'
    </script>
    @include('layouts.head', ['title' => 'Платежи'])
</head>
<body>
@include('layouts.navigation')
<div class="content">
    <div class="main-content">
        <div class="nav">@include('layouts.nav-panel', ['active' => 'payments'])</div>
        <div class="client-table">
            @include('layouts.table', ['name' => 'Платежи', 'head' => ['Сумма' => 'filter', 'Оплачено' => 'nofilter', 'Заказ' => 'nofilter'], 'keys' => ['sum' => 'edit', 'paid' => 'edit', 'order_id' => 'no_edit']])
        </div>
    </div>

</div>
@include('layouts.footer')
</body>
</html>
