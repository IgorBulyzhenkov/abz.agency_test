<script type="module">
    const tableEl   = document.getElementById('myTableBody');
    const listEl    = document.getElementById('list_pagination');
    const prevEl    = document.getElementById('prev');
    const nextEl    = document.getElementById('next');

    async function users(page = '?page=1') {
        await fetch(` {{ route("users.api") }}/${page}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ошибка сети или сервера');
                }
                return response.json();
            })
            .then(res => {

                if (res.errors) {
                    return;
                }

                let prev = '';

                if(res.links.prev_url){

                    prev = res.links.prev_url.split('?').at(-1);

                    if(prev === 'page=1'){
                        prev = "{{ route('users') }}";
                    }else{
                        prev = "{{ route('users') }}" + '/?' + res.links.prev_url.split('?').at(-1);
                        prevEl.classList.remove('disabled');
                    }
                }else{
                    prevEl.classList.add('disabled');
                }

                let next = '';

                if(res.links.next_url){
                    next += "{{ route('users') }}" + '/?' + res.links.next_url.split('?').at(-1);
                    nextEl.classList.remove('disabled');
                }else{
                    nextEl.classList.add('disabled');
                }

                prevEl.href     = prev;
                nextEl.href     = next;

                const baseUrl = '{{ route('users', ['id' => 'PLACEHOLDER']) }}';

                $('#total').html(`${res.total_users}`);

                res.users.map(item => {

                    const urlWithId = baseUrl.replace('PLACEHOLDER', item.id);

                    const img = item.photo ? `${item.photo}` : '/images/nonprofile.webp';
                    const tBodyEl = '<tr>' +
                                        `<th scope="row">${item.id}</th>` +
                                        `<td><img alt="${item.name}" src="${img}" width="70"/></td>` +
                                        `<td>${item.name}</td>` +
                                        `<td>${item.position}</td>` +
                                        `<td><a href="mailto:${item.email}">${item.email}</a></td>` +
                                        `<td> <a href="tel:${item.phone}">${item.phone}</a></td>` +
                                        `<td> <a href="${urlWithId}" class="btn btn-primary"><p class="eye"></p></a></td>` +
                                    '</tr>';

                    tableEl.insertAdjacentHTML('beforeend', tBodyEl);
                });

            })
            .catch(error => {
                console.log(error);
            });
    }

    const href = window.location.href;
    let searchString = "?";
    let index = href.indexOf(searchString);

    if(index){
        const linkPage = '?' + href.split('?')[href.split('?').length - 1];
        users(linkPage);
    }else{
        users();
    }
</script>
