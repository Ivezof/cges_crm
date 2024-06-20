const processing_hopper = $('#processing');
const wait_payment_hopper = $('#wait_payment');
const active_hopper = $('#active');
const checking_hopper = $('#checking');
const complete_hopper = $('#complete');
let edit_modal_el = $('#edit_modal')
let edit_modal_clone = edit_modal_el.clone();


async function getAllOrders() {
    return await axios.get('/api/orders')
        .then((response) => {
            return response
        })
        .catch((error) => {
            console.log(error)
        })
}

async function getOrder(id){
    return await axios.get(`/api/orders/get/${id}`)
        .then((response) => {
            return response['data']
        })
        .catch((error) => {
            console.log(error)
        })

}

async function getWorkers() {
    return await axios.get('/api/workers/all')
        .then((response) => {
            return response['data']
        })
        .catch((error) => {
            console.log(error)
        })
}


async function updateOrder(order_id, description, address, budget, spent, workers, status, payment_status) {
    return await axios.post('/api/orders/update', {
        'order_id': order_id,
        'description': description,
        'address': address,
        'budget': budget,
        'spent': spent,
        'workers': workers,
        'status': status,
        'payment_status': payment_status
    })
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.log(error)
        })
}

async function init() {
    let orders = await getAllOrders();
    $('.hopper-cards').empty();
    orders = orders['data'];
    orders.forEach((order) => {
       const status = order['status'];
       const client = order['client'];
       const endOrder = order['endOrder'] ? order['endOrder'].split(' ')[0] : '';

       switch (status) {
           case 0:
               processing_hopper.find('.hopper-cards').append(`<div class="hopper-card mb-3" order_id="${order['id']}">
                        <div class="card" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5 class="card-title">Заказ ${order['id']}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Дата окончания: ${endOrder}</h6>
                                </li>
                                <li class="list-group-item"><p class="card-text">Адрес: ${order['address']}</p></li>
                            </ul>
                            <div class="card-footer">ФИО клиента: ${client['fio']}</div>
                        </div>
                    </div>`)
               break;
           case 1:
               wait_payment_hopper.find('.hopper-cards').append(`<div class="hopper-card mb-3" order_id="${order['id']}">
                        <div class="card" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5 class="card-title">Заказ ${order['id']}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Дата окончания: ${endOrder}</h6>
                                </li>
                                <li class="list-group-item"><p class="card-text">Адрес: ${order['address']}</p></li>
                            </ul>
                            <div class="card-footer">ФИО клиента: ${client['fio']}</div>
                        </div>
                    </div>`)
               break;
           case 2:
               active_hopper.find('.hopper-cards').append(`<div class="hopper-card mb-3" order_id="${order['id']}">
                        <div class="card" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5 class="card-title">Заказ ${order['id']}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Дата окончания: ${endOrder}</h6>
                                </li>
                                <li class="list-group-item"><p class="card-text">Адрес: ${order['address']}</p></li>
                            </ul>
                            <div class="card-footer">ФИО клиента: ${client['fio']}</div>
                        </div>
                    </div>`)
               break;
           case 3:
               checking_hopper.find('.hopper-cards').append(`<div class="hopper-card mb-3" order_id="${order['id']}">
                        <div class="card" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5 class="card-title">Заказ ${order['id']}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Дата окончания: ${endOrder}</h6>
                                </li>
                                <li class="list-group-item"><p class="card-text">Адрес: ${order['address']}</p></li>
                            </ul>
                            <div class="card-footer">ФИО клиента: ${client['fio']}</div>
                        </div>
                    </div>`)
               break;
           case 4:
               complete_hopper.find('.hopper-cards').append(`<div class="hopper-card mb-3" order_id="${order['id']}">
                        <div class="card" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h5 class="card-title">Заказ ${order['id']}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Дата окончания: ${endOrder}</h6>
                                </li>
                                <li class="list-group-item"><p class="card-text">Адрес: ${order['address']}</p></li>
                            </ul>
                            <div class="card-footer">ФИО клиента: ${client['fio']}</div>
                        </div>
                    </div>`)
               break;
       }
    });
    $('.hopper-card').on('click', async (ev) => {
        const card = $(ev.currentTarget);
        const id = card.attr('order_id');
        const order = await getOrder(id);
        const main_content = edit_modal_el.parent();
        edit_modal_el.remove()

        edit_modal_el = edit_modal_clone.clone();
        main_content.append(edit_modal_el);
        edit_modal_el.find('#description').val(order['description']);
        edit_modal_el.find('#address').val(order['address']);
        edit_modal_el.find('#budget').val(order['budget']);
        edit_modal_el.find('#spent').val(order['spent']);

        if (order['status'] === 1) {
            $('#workers_select_menu').remove();
            edit_modal_el.find('#budget').prop('disabled', true);
            edit_modal_el.find('#spent').prop('disabled', true);
        } else if (order['status'] > 1) {
            $('#workers_select_menu').remove();
            edit_modal_el.find('input').prop('disabled', true);
            edit_modal_el.find('textarea').prop('disabled', true);
        }
        let workers_select = $('#workers');
        const workers = await getWorkers();
        workers['workers'].forEach((worker) => {
            workers_select.append(`
            <option value="${worker['id']}">${worker['id'] + ' - ' + worker['name']}</option>
        `)
        });

        let selected = [];
        workers_select.on('change', (ev) => {
            const user_id = $(ev.target).val();
            const username = $(ev.target).find('option:selected').text();
            selected.push(Number(user_id));
            workers_select.find(`option[value=${user_id}]`).remove();
            workers_select.find(`option:first`).prop('selected', true);

            const selected_workers = $('#selected_workers')
            selected_workers.append(`
            <span class="badge text-bg-primary badge-worker" user_id="${user_id}">${username} <i class="bi bi-x"></i></span>
            `)

            selected_workers.find(`span[user_id=${user_id}]`).on('click', (ev) => {
                console.log($(ev.delegateTarget).attr('user_id'))
                console.log(ev)
                const user_id = $(ev.delegateTarget).attr('user_id');
                selected.splice(selected.indexOf(user_id), 1);
                $(ev.delegateTarget).remove();
                workers_select.empty();
                workers_select.append('<option selected disabled>Выберите сотрудника</option>')
                workers['workers'].forEach((worker) => {
                    if (selected.indexOf(worker['id']) === -1) {
                        workers_select.append(`
                            <option value="${worker['id']}">${worker['id'] + ' - ' + worker['name']}</option>
                        `)
                    }

                });
            })

        });
        console.log(selected)

        if (order['status'] + 1 < 5) {
            const next_btn = edit_modal_el.find('#next_btn')
            next_btn.attr('next_status', order['status'] + 1);
            next_btn.on('click', async (ev) => {
                if (selected.length === 0 && order['status'] === 0) {
                    alertMsg('Ошибка', 'danger', 'Необходимо выбрать как минимум 1 работника', 'white');
                    return;
                }
                const budget = edit_modal_el.find('#budget').val()
                const spent = edit_modal_el.find('#spent').val();
                const description = edit_modal_el.find('#description').val();
                const address = edit_modal_el.find('#address').val();
                if ((!budget || !spent) && order['status'] === 0) {
                    alertMsg('Ошибка', 'danger', 'Поля бюджет и затраты не должны быть пустыми', 'white');
                    return;
                }
                switch (order['status']) {
                    case 0:
                        // TODO
                        // отправлять уведомление об оплате по почте
                        await updateOrder(order['id'], description, address, Number(budget), Number(spent), selected, 1, false);
                        edit_modal.hide()
                        await init()
                        break;
                    case 1:
                        // TODO
                        // Отправлять уведомление о начале выполнения
                        await updateOrder(order['id'], description, address, null, null, null, 2, true);
                        edit_modal.hide()
                        await init()
                        break;
                    case 2:


                        await updateOrder(order['id'], null, null, null, null, null, 3, true);
                        edit_modal.hide()
                        await init()
                        break;
                    case 3:

                        // TODO
                        // отправлять уведомление о завершении заказа
                        await updateOrder(order['id'], null, null, null, null, null, 4, true);
                        edit_modal.hide()
                        await init()
                        break;
                }

            })
        } else if(order['status'] === 4) {
            $('#next_btn').prop('disabled', true)

            edit_modal_el.find('input').prop('disabled', true);
        }
        const edit_modal = new bootstrap.Modal('#edit_modal');
        edit_modal.show();
    })
}
init();
