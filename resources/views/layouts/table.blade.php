
<script>
    let keys = {}
    let heads = []
    @foreach($keys as $key => $v)
        keys['{{$key}}'] = '{{ $v }}'
    @endforeach
    @foreach($head as $name => $v)
        heads.push('{{ $name }}')
    @endforeach

</script>
<div class="table-content">
    <div class="page-name">{{ $name }}</div>

    <div class="modal fade" id="delete_confirm_modal" tabindex="-1" aria-labelledby="delete_confirm_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="delete_confirm_modal_label">Удаление</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вы точно хотите удалить эти записи?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="deleteModalConfirm">Удалить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_modal" tabindex="-1" aria-labelledby="edit_modal_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit_modal_label">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="editModal">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="editModalConfirm">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="delete_menu" id="delete_menu">
            <div onclick="this.querySelector('input').checked = !this.querySelector('input').checked; pick_all_items(this.querySelector('input'));">
                <label>
                    <input type="checkbox" class="table-checkbox form-check-input" id="delete_menu-checkbox">
                </label>
            </div>
            <div class="delete_btn" id="delete_btn">
                Удалить
            </div>
            <div class="edit_btn" id="edit_btn">
                Редактировать
            </div>
        </div>
        <table class="table clients-table_table table-bordered" id="table" url-method="/table/clients">
            <thead class="table-head align-middle">
            <tr>
                <th onclick="this.querySelector('input').checked = !this.querySelector('input').checked; pick_all_items(this.querySelector('input')); ">
                    <label>
                        <input type="checkbox" class="table-checkbox form-check-input" id="all_check">
                    </label>
                </th>
                @foreach($head as $thValue => $thFilter)
                    <th scope="col" @if($thFilter == 'filter') class="filtered" @endif>{{ $thValue }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            </tbody>

        </table>

    </div>
    <nav class="pagination-block align-middle">
        <ul class="pagination" id="pagination">
{{--            <li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}

{{--            <li class="page-item">--}}
{{--                <a class="page-link" href="#" aria-label="Next" id="next_url">--}}
{{--                    <span aria-hidden="true">&raquo;</span>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
        <div class="dropdown align-middle" id="dropdown_perpage">
            <p>Показывать на странице: </p>
            <a class="dropdown-toggle" href="#" role="button" id="perPage" data-bs-toggle="dropdown" aria-expanded="false">
                10
            </a>
            <ul class="dropdown-menu" aria-labelledby="perPage">
                <li><a class="dropdown-item" href="#" onclick="initTable(1, 5)">5</a></li>
                <li><a class="dropdown-item" href="#" onclick="initTable(1, 10)">10</a></li>
                <li><a class="dropdown-item" href="#" onclick="initTable(1, 15)">15</a></li>
                <li><a class="dropdown-item" href="#" onclick="initTable(1, 20)">20</a></li>
            </ul>
        </div>
    </nav>

    @include('layouts.message')
</div>

<script src="{{ asset('/storage/js/table.js') }}"></script>

