<!doctype html>
<html lang="en">
<head>
    @include('layouts.head', ['title' => 'Создание заказа'])
</head>
<body>
@include('layouts.navigation')
<div class="content" style="margin-bottom: 100px">
    <form class="login-form" action="{{ route('addOrder') }}" method="POST" id="order">
        <legend>Заявка на обслуживание</legend>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">ФИО</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
            <div class="invalid-feedback" format-text='Допустимые символы: "а" до "я", пробел'>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Почта</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="mb-3">
            <label for="telegram" class="form-label">Телеграм</label>
            <input type="text" class="form-control @error('telegram') is-invalid @enderror" name="telegram" id="telegram" value="{{ old('telegram') }}" required>
            <div class="invalid-feedback" format-text='Допустимые символы: "@", "a" до "z", "_"'>
            </div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Номер телефона</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" required>
            <div class="invalid-feedback" format-text='Допустимые символы: +, цифры от 0 до 9'>
            </div>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address') }}" required>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание заказа</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" required>{{ old('description') }}</textarea>
            <div class="invalid-feedback">
            </div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="agree" name="agree">
            <label class="form-check-label" for="agree">Согласен на обработку персональных данных</label>
            <div class="invalid-feedback">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Оформить</button>
    </form>

    <div class="modal fade" id="emailMsg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="emailMsgLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="emailMsgLabel">Подтверждение Email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Для оформления заказа необходимо подтвердить почту. Вам было отправлено письмо для подтверждения.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Подтвердить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="emailMsgVerified" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="emailMsgVerifiedLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="emailMsgVerifiedLabel">Подтверждение Email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Почта подтверждена и заказ создан.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('storage/js/sendform.js') }}"></script>
</div>
@include('layouts.footer', ['notapp' => true])
</body>
</html>
