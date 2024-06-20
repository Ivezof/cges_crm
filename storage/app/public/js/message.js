function alertMsg(title, type, msg_text, text_color) {
    const divMsg = $('#divMsg');
    const msg = new bootstrap.Toast(document.getElementById('msg'));
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
