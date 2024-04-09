<script type="module">
    const formEl = document.getElementById('form_user');

    async function handleSubmit(e) {
        e.preventDefault();

        $(`#span_phone`).html('');
        $(`#span_name`).html('');
        $(`#span_email`).html('');
        $(`#span_photo`).html('');

        const formData = new FormData(e.target);

        const form = e.target;
        const elements = form.elements;

        for (let i = 0; i < elements.length; i++) {
            elements[i].classList.remove('has-error');
            elements[i].parentElement.classList.remove('has-error');
        }

        const token = localStorage.getItem('token');

        if (token) {
            formData.append('token', token);
        }

        await fetch(`{{ route('users.store') }}`, {
            method: 'POST',
            body: formData
        })
            .then(res => {
                return res.json();
            })
            .then(res => {
                if(!res.status){
                    $.notify(res.message, "error");

                    Object.keys(res.fails).forEach(key => {
                        const inputName = key;
                        const $input = $(`input[name="${inputName}"]`);
                        if ($input.length > 0) {
                            $input.addClass('has-error');
                            $input.parent().addClass('has-error');
                            $(`#span_${key}`).html(res.fails[key]);
                        }
                    });
                }else{
                    $(`input[name="name"]`).val('');
                    $(`input[name="email"]`).val('');
                    $(`input[name="phone"]`).val('');
                    $(`input[name="photo"]`).val('');

                    $.notify(res.message, "success");

                    $('#backdrop').removeClass('display_block');
                    $('#body').removeClass('none_scroll');
                    let currentTotal = parseInt($('#total').html());

                    currentTotal += 1;

                    $('#total').html(currentTotal);
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    formEl.addEventListener('submit', handleSubmit)
</script>
