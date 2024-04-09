<script type="module">
    const href = window.location.href;
    const idUser = href.split('/').at(-1);

    fetch(`{{ route('users.api') }}/${idUser}`, {
        method: 'GET'
    }).then(res => {
        return res.json();
    }).then(res => {

        if (!res.status) {
            $.notify(res.message, "error");
            return;
        }

        Object.keys(res.user).forEach(key => {
            const $el = $(`#${key}`);
            if ($el.length > 0) {

                switch (key) {
                    case 'photo':
                        if (res.user[key]) {
                            $el[0].src = res.user[key];
                            break;
                        }
                        break;

                    case 'email':
                        if (res.user[key]) {
                            $el[0].href = 'mailto:' + res.user[key];
                            $el.html(res.user[key]);
                            break;
                        }
                        break;

                    case 'phone':
                        if (res.user[key]) {
                            $el[0].href = 'tel:' + res.user[key];
                            $el.html(res.user[key]);
                            break;
                        }
                        break;

                    case 'registration_timestamp':
                        if (res.user[key]) {
                            const date = new Date(res.user[key]);

                            const day = Number(date.getDate()) < 10 ? '0' + date.getDate() : date.getDate();

                            const month = date.getMonth() + 1
                            const newMonth = Number(month) < 10 ? '0' + month : month;

                            const hours = Number(date.getHours()) < 10 ? '0' + date.getHours() : date.getHours();
                            const minute = Number(date.getMinutes()) < 10 ? '0' + date.getMinutes() : date.getMinutes();

                            const formattedDate = `${day}.${newMonth}.${date.getFullYear()} ${hours}:${minute}`;

                            $el.html(formattedDate);
                            break;
                        }
                        break;

                    default:
                        $el.html(res.user[key]);
                        break;
                }
            }
        });

    }).catch(error => {
        console.log(error);
    });

</script>
