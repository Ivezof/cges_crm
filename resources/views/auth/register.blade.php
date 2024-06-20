<!doctype html>
<html lang="en">
<head>
    @include('layouts.head', ['title' => 'Регистрация'])
</head>
<body>
@include('layouts.navigation')
<div class="content">
    <div class="main-content">
        <div class="nav">@include('layouts.nav-panel', ['active' => 'register'])</div>
        <form class="login-form" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
                <div class="invalid-feedback">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                <div class="invalid-feedback">
                    @error('email') {{ $message }} @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Должность</label>
                <select class="form-select" aria-label="Default select example" name="role" id="role">
                    <option value="0">Рабочий</option>
                    <option value="1">Менеджер</option>
                    <option value="2">Администратор</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Повторите пароль</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Зарегистрировать</button>
        </form>
    </div>

</div>
@include('layouts.footer')
</body>
</html>
