<!doctype html>
<html lang="ru">
<head>
    @include('layouts.head', ['title' => 'Заказы'])
</head>
<body>
@include('layouts.navigation')
<div class="content">
    <div class="main-content">
        <div class="nav">@include('layouts.nav-panel', ['active' => 'orders'])</div>

        <div class="modal" tabindex="-1" id="edit_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-hopper">
                            <div class="mb-3">
                                <label for="description" class="col-form-label">Описание</label>
                                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="col-form-label">Адрес</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                            <div class="mb-3">
                                <label for="budget" class="col-form-label">Стоимость</label>
                                <input type="number" class="form-control" id="budget" name="budget">
                            </div>
                            <div class="mb-3">
                                <label for="spent" class="col-form-label">Затраты</label>
                                <input type="number" class="form-control" id="spent" name="spent">
                            </div>
                            <div class="mb-3" id="workers_select_menu">
                                <label for="workers" class="col-form-label">Рабочие</label>
                                <div class="selected_workers" id="selected_workers">
                                </div>
                                <select class="form-select" aria-label="Default select example" name="workers" id="workers">
                                    <option selected disabled>Выберите сотрудника</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" id="next_btn">Далее</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="hoppers">
            <div class="hopper" id="processing">
                <div class="hopper-title gray-bb">В обработке</div>
                <div class="hopper-cards">

                </div>
            </div>
            <div class="hopper" id="wait_payment">
                <div class="hopper-title yellow-bb">Ожидает платежа</div>
                <div class="hopper-cards">
                </div>
            </div>
            <div class="hopper" id="active">
                <div class="hopper-title purple-bb">Активно</div>
                <div class="hopper-cards">

                </div>
            </div>
            <div class="hopper" id="checking">
                <div class="hopper-title blue-bb">На проверке</div>
                <div class="hopper-cards">

                </div>
            </div>
            <div class="hopper" id="complete">
                <div class="hopper-title green-bb">Выполнено</div>
                <div class="hopper-cards">

                </div>
            </div>
        </div>
    </div>

    @include('layouts.message')

</div>
<script src="{{ asset('storage/js/hoppers.js') }}"></script>
@include('layouts.footer')
</body>
</html>
