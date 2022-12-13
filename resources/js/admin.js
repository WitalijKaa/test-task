require('./bootstrap');

window.addEventListener("load", (event) => {

    document.querySelectorAll('[data-reset-btn-id]').forEach((elem) => {
        elem.addEventListener('click', () => {

            let id = elem.dataset.resetBtnId;
            if (!id) { return; }

            axios.put('/api/v1/image/' + id).then(() => {
                document.querySelector('[data-status-id="' + id + '"]').innerHTML = 'Undefined';
            });
        });
    });
});

