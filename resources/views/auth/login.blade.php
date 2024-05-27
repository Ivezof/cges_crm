<!doctype html>
<html lang="en">
<head>
    @include('layouts.head', ['title' => 'Авторизация'])
</head>
<body>
    <div class="content">
            <form class="login-form" action="{{ route('login-store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Почта</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                    <div class="invalid-feedback">
                        @error('email') {{ $message }} @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    @include('layouts.footer')
</body>
</html>
