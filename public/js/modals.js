const backdropEl    = document.getElementById("backdrop");
const addEl         = document.getElementById('add');
const modalClose    = document.getElementById('close');
const modalForm     = document.getElementById('modal_form');
const bodyEl        = document.getElementById('body');
function toggleModal(e){
    backdropEl.classList.toggle('display_block');
    bodyEl.classList.toggle('none_scroll');
}

modalForm.addEventListener('click', (event) => {
    event.stopPropagation();
});


addEl.addEventListener('click', toggleModal);
backdropEl.addEventListener('click', toggleModal);
modalClose.addEventListener('click', toggleModal);
