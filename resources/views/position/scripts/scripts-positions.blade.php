<script type="module">
    const tableEl   = document.getElementById('positionTableBody');

    fetch(`{{ route('positions.api') }}`,{
        method: 'GET'
    }).then( res => {
        return res.json();
    }).then( res => {

        if(!res.status){
            $.notify(res.message, 'error');
        }
        res.positions.map(item => {

            const tBodyEl = '<tr>' +
                                `<th scope="row">${item.id}</th>` +
                                `<td>${item.name}</td>` +
                            '</tr>';

            tableEl.insertAdjacentHTML('beforeend', tBodyEl);
        });
        console.log(res);

    }).catch( error => {
        console.log(error);
    });
</script>
