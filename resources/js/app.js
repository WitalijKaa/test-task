require('./bootstrap');

window.test12app = {
    lastID: null,
    nextUrls: [],
    statuses: {
        approve: 1,
        decline: 2,
    },
};

window.addEventListener("load", (event) => {

    init().then(() => { showPhoto(); })

    function showPhoto() {
        if (!window.test12app.nextUrls.length) {
            findNextUrls(1).then(() => { showPhoto(); });
        } else {
            let item = window.test12app.nextUrls.shift();
            document.getElementById('photo').src = item.url;
            document.getElementById('approve').dataset.id = item.id;
            document.getElementById('decline').dataset.id = item.id;
        }
    }

    async function init() {
        await findLastID();
        await findNextUrls(1);
    }

    async function findNextUrls(page) {
        await axios.get('https://picsum.photos/v2/list/?page=' + page + '&limit=100').then(function (response) {
            window.test12app.nextUrls = response.data.filter((item) => {
                    if (!item.id || +item.id <= window.test12app.lastID) {
                        return false
                    }
                    return true;
                })
                .map((item) => {
                    let url = item.download_url.split('/');
                    url[url.length - 1] = '500';
                    url[url.length - 2] = '600';
                    return { id: +url[url.length - 3], url: url.join('/') }
                });
        });

        if (!window.test12app.nextUrls.length) {
            await findNextUrls(page + 1);
        }
        console.log('##', window.test12app.nextUrls.length)
    }

    async function findLastID() {
        await axios.get('/api/v1/last-id')
            .then(function (response) {
                window.test12app.lastID = +response.data.item;
            });
    }

    ['approve', 'decline'].forEach((elemID) => {
        document.getElementById(elemID).addEventListener('click', (event) => {
            event.preventDefault();

            let id = document.getElementById(elemID).dataset.id;
            if (!id) { return; }

            axios.post(
                '/api/v1/image/' + id + '/' + window.test12app.statuses[elemID],
                { url: document.getElementById('photo').src }
            )
                .finally(() => { showPhoto(); });
        });
    });
});

