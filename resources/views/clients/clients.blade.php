<!doctype html>
<html lang="ru">
<head>
    @include('layouts.head', ['title' => 'Клиенты'])
</head>
<body>
    @include('layouts.navigation')
    <div class="content">
        <div class="nav">@include('layouts.nav-panel', ['active' => 'clients'])</div>
        <div class="table">
            <table>
                <tr>
                    <th>[]</th>
                    <th>ФИО</th>
                    <th>Почта</th>
                    <th>Номер телефона</th>
                    <th>Телеграм</th>
                    <th>Активные заказы</th>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    @include('layouts.footer')
</body>
</html>
