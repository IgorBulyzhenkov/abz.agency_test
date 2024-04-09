<script type="module">
    const buttonAddEl   = document.getElementById('add');
    const getTokenEL    = document.getElementById('token');

    async function getToken()
    {
        await fetch( `{{ route('token') }}` , {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        }).then( response => {
            if (!response.ok) {
                throw new Error('Error serv or ');
            }
            return response.json();
        }).then( res => {
            if(res.status){
                const time = new Date().getTime() + ( 2400 * 1000 );
                localStorage.setItem("token", res.token);
                localStorage.setItem('timeToken', String(time));

                buttonAddEl.style.display   = 'block';
                getTokenEL.style.display    = 'none';
                getTimeToken();
            }

        }).catch( error => {
            console.log(error);
        });
    }

    function getTimeToken()
    {
         const intervalTime = setInterval( () => {
            const time              = new Date().getTime();
            const localStorageTime  = localStorage.getItem('timeToken')

            if(Number(time) >= Number(localStorageTime)){
                localStorage.removeItem('timeToken');
                localStorage.removeItem('token');

                buttonAddEl.style.display   = 'none';
                getTokenEL.style.display    = 'block';
                clearInterval(intervalTime);
            }else{
                buttonAddEl.style.display   = 'block';
                getTokenEL.style.display    = 'none';
            }
        },1000);
    }

    getTimeToken();

    getTokenEL.addEventListener('click', getToken);
</script>
