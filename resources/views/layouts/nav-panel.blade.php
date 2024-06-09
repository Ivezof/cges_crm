<div class="nav-panel" id="nav_panel">
    <div class="burger-menu" id="bm">
        <div class="burger-line"></div>
        <div class="burger-line"></div>
        <div class="burger-line"></div>
    </div>
    <div class="buttons-menu">
        <a href="{{ route('dashboard') }}" class="panel nav-item @if($active == 'dashboard') nav-active @endif">
            <img src="{{ asset('storage/img/panel-icon.svg') }}" class="icon-btn" alt="panel">
            <div class="btn-name">Панель</div>
        </a>
        <a href="{{ route('clients') }}" class="clients nav-item @if($active == 'clients') nav-active @endif">
            <img src="{{ asset('storage/img/clients-icon.svg') }}" class="icon-btn" alt="panel">
            <div class="btn-name">Клиенты</div>
        </a>
        <a href="{{ route('payments') }}" class="payments nav-item @if($active == 'payments') nav-active @endif">
            <img src="{{ asset('storage/img/payments-icon.svg') }}" class="icon-btn" alt="panel">
            <div class="btn-name">Платежи</div>
        </a>
        <a href="#" class="clients nav-item @if($active == 'orders') nav-active @endif">
            <img src="{{ asset('storage/img/orders-icon.svg') }}" class="icon-btn" alt="panel">
            <div class="btn-name">Заказы</div>
        </a>
        <a href="#" class="clients nav-item @if($active == 'workers') nav-active @endif">
            <img src="{{ asset('storage/img/workers-icon.svg') }}" class="icon-btn" alt="panel">
            <div class="btn-name">Сотрудники</div>
        </a>
    </div>
</div>
