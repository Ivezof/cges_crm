<!doctype html>
<html lang="ru">
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('storage/js/chart.js') }}"></script>
    @include('layouts.head', ['title' => 'Меню'])
</head>
<body>
    @include('layouts.navigation')
    <div class="content">
        <div class="main-content">
            <div class="nav">@include('layouts.nav-panel', ['active' => 'dashboard'])</div>
            <div class="stats_graphs">
                <div class="stats">
                    <div class="filter">
                        <div class="period-elem" id="yesterday">Вчера</div>
                        <div class="period-elem active-filter" id="today">Сегодня</div>
                        <div class="period-elem" id="week">Неделя</div>
                        <div class="period-elem" id="month">Месяц</div>
                    </div>
                    <div class="stat-cards">
                        <div class="stat-elem">
                            <h1 class="title-stat_elem">Выполненные заказы</h1>
                            <div class="card-text"><p class="text-stat_elem stat-green" id="stats-complete">0</p><span class="period-text">за сегодня</span></div>
                        </div>
                        <div class="stat-elem">
                            <h1 class="title-stat_elem">Отмененные заказы</h1>
                            <div class="card-text"><p class="text-stat_elem stat-blue" id="stats-canceled">0</p><span class="period-text">за сегодня</span></div>
                        </div>
                        <div class="stat-elem">
                            <h1 class="title-stat_elem">Активные заказы</h1>
                            <div class="card-text"><p class="text-stat_elem stat-purple" id="stats-active">0</p><span class="period-text">за сегодня</span></div>
                        </div>
                    </div>
                </div>
                <div class="chart" id="chart_div"></div>
            </div>
        </div>
    </div>
    <script src="{{ asset('storage/js/filter.js') }}"></script>
    @include('layouts.footer')
</body>
</html>
