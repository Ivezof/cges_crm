window.onload = () => {
    let modal = new bootstrap.Modal(document.getElementById("emailMsg"), {})
    let modalVerify = new bootstrap.Modal(document.getElementById('emailMsgVerified'), {});
    let form = document.getElementById('order');

    const errors = {}
    let success = '';

    if (window.location.search) {
        let verified = new URL(window.location.href).searchParams.get('verified');
        if (verified === 'true') {
            modalVerify.show();
        }
    }

    form.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        let inputs = ev.target.querySelectorAll('[name]');
        let data = {};
        [].forEach.call(inputs, function (el) {
            if (el.name === 'agree') {
                data[el.name] = !!el.checked;
            } else {
                data[el.name] = el.value;
            }

        });
        console.log(data);
        await axios.post('/order', data)
            .then((response) => {
                console.log(435345)
                modal.show()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            })
        for (let error in errors.value) {
            console.log(errors.value[error].join('<br>'))
            form.querySelector(`input[name="${error}"]`).classList.add('is-invalid');
            let text = form.querySelector(`input[name="${error}"]`).parentNode.querySelector('.invalid-feedback').getAttribute('format-text');
            form.querySelector(`input[name="${error}"]`).parentNode.querySelector('.invalid-feedback').innerHTML = errors.value[error].join('<br>') + "<br>" + (text ? text : '');
        }

    })
}
