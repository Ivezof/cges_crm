api_point = '/api'
let per_page = 10

const delete_confirm_modal = new bootstrap.Modal('#delete_confirm_modal');

const msg = new bootstrap.Toast(document.getElementById('msg'));

const editModal = $('#edit_modal');

const edit_modal_bs = new bootstrap.Modal('#edit_modal');

const divMsg = $('#divMsg');

let order_by = ['id', 'asc'];

editModal.on('show.bs.modal', () => {

})

async function getObject(id, type) {
    const method = `/${type}/get`
    return await axios.get(api_point + method, {
        params: {
            id: id
        }
    }).then((response) => {
        console.log(response)
        return response['data'][`${type}`];
    }).catch((error) => {
        console.log(error);
    });
}

function pick_item(elem) {
    let checkbox = elem.querySelector('td>label>input');
    checkbox.checked = !checkbox.checked;
    //
    if (!$('#delete_menu-checkbox').is(':checked')) {
        pick_item_del_menu(checkbox.checked)
    }

    let all_checked = true;
    let all_uncheck = true;
    let checkbox_checked_count = 0;
    let edit_btn = $('#edit_btn');
    $('table>tbody [type=checkbox]').each((index, checkbox) => {
        if (!checkbox.checked) {
            all_checked = false;
        } else {
            all_uncheck = false;
            checkbox_checked_count += 1;
        }
    })
    $('#all_check').prop('checked', all_checked);
    if (all_uncheck) {
        pick_item_del_menu(false);
    }

    if (checkbox_checked_count === 1) {
        edit_btn.css('display', 'flex')
    } else {
        edit_btn.css('display', 'none')
    }

}

function pick_item_del_menu(checked) {
    console.log('del menu')
    $("#delete_menu-checkbox").prop('checked', checked);
    let delete_menu = $('#delete_menu');
    let delete_menu_clone = delete_menu.clone(true);
    console.log(checked)
    if (!checked) {
        if (delete_menu.hasClass('menu_none') || !delete_menu.hasClass('menu_show')) {
            return;
        }
        delete_menu_clone.removeClass('menu_show')
        delete_menu.before(delete_menu_clone);
        delete_menu_clone.addClass('menu_none');
        delete_menu.remove();
        // delete_menu.toggleClass('menu_show');
        // delete_menu.toggleClass('menu_none');

    } else {
        // delete_menu.toggleClass('menu_none');
        // delete_menu.toggleClass('menu_show');
        delete_menu_clone.removeClass('menu_none')
        delete_menu.before(delete_menu_clone);
        delete_menu_clone.addClass('menu_show');
        delete_menu.remove();
    }
    $('#all_check').prop('checked', checked)


}

function pick_all_items(checkbox) {
    let inputs = document.querySelectorAll('.table>tbody>tr>td>label>input');
    checkbox.checked = !checkbox.checked;
    inputs.forEach((el) => {
        el.checked = checkbox.checked;
    });
    console.log(123123)
    $('#edit_btn').css('display', 'none');
    pick_item_del_menu(checkbox.checked)
}

async function get_objects(page, perPage = 10, type, order_by) {
    const method = `/table/${type}`;
    return await axios.get(api_point + method, {
        params: {
            page: page,
            perPage: perPage,
            orderBy: order_by
        },
    })
        .then(function (response) {
            return response.data;
        })
        .catch(function (err) {
            console.log(err);
        });
}
async function initTable(page = 1, perPage = per_page) {
    per_page = perPage;

    const objects = await get_objects(page, perPage, type, order_by);



    let last_page = {'number': objects['last_page'], 'url': objects['last_page_url']};
    let table = $('#table');
    $('#perPage').remove();
    $('#dropdown_perpage p').after(`<a class="dropdown-toggle" href="#" role="button" id="perPage" data-bs-toggle="dropdown" aria-expanded="false">
                                            ${perPage}
                                         </a>`
    )
    $('[type=checkbox]').each((index, checkbox) => {
        checkbox.checked = false;
    });
    table.ready(() => {
        table.find('tbody').empty();
        objects['data'].forEach((el) => {
            let tds = ''
            for (let key in keys) {
               tds += (`<td>${el[key]}</td>`)
            };
            let tr_elem = `<tr onclick="pick_item(this)">
                    <td onclick="this.querySelector('input').checked = !this.querySelector('input').checked" class="checkbox_th">
                        <label>
                            <input type="checkbox" class="table-checkbox form-check-input" object_id="${el['id']}">
                        </label>
                    </td>
                    ${tds}
                </tr>`
            $('#table tbody').append(tr_elem);
        });
    })
    let pagination = $('#pagination');
    pagination.empty();
    let prev_elem = `<li class="page-item">
                                <a class="page-link" href="#" onclick="initTable(${ page - 1 > 0 ? page - 1 : 1})" aria-label="Previous" id="prev_url">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>`
    let next_elem = `<li class="page-item">
                                <a class="page-link" href="#" onclick="initTable(${ page + 1 <= last_page['number'] ? page + 1 : '#'})" aria-label="Next" id="next_url">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>`

    pagination.append(prev_elem);

    let lp = page <= 4 && 7 <= last_page['number'] ? 7 : page + 3 > last_page['number'] ? last_page['number'] : page + 3;

    for (let i = page - 3 > 0 ? page - 3 : 1; i <= lp; i++) {
        pagination.append(`<li class="page-item ${i === page ? 'active" ' + 'page_num=' + i : '"'}><a class="page-link" href="#" onclick="initTable(${i})">${i}</a></li>`)
    }
    pagination.append(next_elem);
}


async function deleteElem(type, ids) {
    let method = `/${type}/delete`
    let objects = [];
    ids.forEach((id) => {
        objects.push({'id': id})
    })
    let data = {};
    data[type] = objects;
    return await axios.post(api_point + method, data,
              {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                     }
    ).then((response) => {
        return true;
    }).catch((error) => {
        return false;
    });
}

$('#editModalConfirm').on('click', async () => {
    let method = `/${type}/update`;
    const form_modal = editModal.find('form');
    const obj_id = editModal.find('#editModalConfirm').attr('object_id');

    let new_obj_json = convertFormToJSON(form_modal);
    new_obj_json['id'] = obj_id;
    console.log(new_obj_json)
    let object = await axios.post(api_point + method, new_obj_json, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then((response) => {
            console.log(response);
            alertMsg('Сохранено', 'success', 'Клиент успешно обновлен', 'white');
            return response;
        }).catch((error) => {
            alertMsg('Ошибка', 'danger', 'Произошла ошибка при обновлении', 'white');
            console.log(error);
        })
    await initTableSave();
});


function convertFormToJSON(form) {
    const json = {};
    $(form).find('input').each((index, el) => {
        console.log(el)
        json[el.getAttribute('id')] = $(el).val() || "";
    });
    return json;
}

function alertMsg(title, type, msg_text, text_color) {
    divMsg.find('#msg').addClass(`bg-${type} text-${text_color}`);
    divMsg.find('strong').text(title);
    divMsg.find('.toast-body').text(msg_text);

    msg.show()
    const msgObj = $('#msg');
    msgObj.on('hidden.bs.toast', () => {
        msgObj.find('strong').text('');
        msgObj.find('.toast-body').text('');
        msgObj.removeClass(`bg-${type}`);
        msgObj.removeClass(`text-${text_color}`);
    });
}

$('#edit_btn').on('click', async () => {
    let id = 0;
    $('#table>tbody input[type=checkbox]').each((index, el) => {
        if (el.checked) {
            id = Number(el.getAttribute('object_id'));
        }
    })
    const object = await getObject(id, type);
    console.log('type: ', type)
    const form_modal = editModal.find('form');
    let index = 0;
    for (let key in keys) {
        if (keys[key] === 'edit') {
            form_modal.append(`<div class="mb-3">
                                <label for="${key}" class="col-form-label">${heads[index]}</label>
                                <input type="text" class="form-control" id="${key}" value="${object[key]}">
                                </div>`)
        }

        index++;
    }
    editModal.find('#editModalConfirm').attr('object_id', object['id'])
    edit_modal_bs.show()

})

editModal.on('hidden.bs.modal', () => {
    const form_modal = editModal.find('form');
    form_modal.empty();
});


$('#delete_btn').on('click', () => {
    delete_confirm_modal.show()
});

$('#deleteModalConfirm').on('click', async () => {
    let all_checked_lines = $('#table>tbody input[type=checkbox]');
    let ids = []
    all_checked_lines.each((index, line) => {
        if (line.checked) {
            ids.push(line.getAttribute('object_id'))
        }
    });
    const result = await deleteElem(type, ids);

    await initTableSave();
    console.log(result)
    if (result) {
        alertMsg('Успешно удалено!', 'success', 'Клиенты успешно удалены!', 'white');
    } else {
        alertMsg('Ошибка', 'danger', 'Произошла ошибка на сервере, перезагрузите страницу и попробуйте еще раз', 'white')
    }

})

$('[orderBy]').each((index, el) => {
    console.log(el)
    $(el).on('click', () => {
        let orderBy = $(el).attr('orderby');
        let status = Number($(el).attr('status'));
        console.log(status)
        switch (status) {
            case 0:
                order_by = [orderBy, 'asc'];
                initTableSave();
                $(el).attr('status', status + 1);
                $(el).removeClass('filtered').addClass('filteredTop');
                break;
            case 1:
                order_by = [orderBy, 'desc'];
                initTableSave();
                $(el).attr('status', status + 1);
                $(el).removeClass('filteredTop').addClass('filteredDown');
                break;
            case 2:
                order_by = ['id', 'asc'];
                initTableSave();
                $(el).attr('status', 0);
                $(el).removeClass('filteredDown').addClass('filtered');
                break;
        }
    });
})

async function initTableSave() {
    await initTable(Number($('li[page_num]').attr('page_num')[0]), Number($('#perPage').text()));
    pick_item_del_menu(false);
}

initTable();
