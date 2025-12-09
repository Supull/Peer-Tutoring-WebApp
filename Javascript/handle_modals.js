


function openModal(modal) {if(modal){modal.style.display = 'flex';}}
function closeModal(modal) {if(modal){modal.style.display = 'none';}}

function handleOpenModal(event){
    const modalTarget = document.querySelector(event.target.getAttribute('data-modal-target'));
    openModal(modalTarget);
}

function handleCloseModal(event){
    if (event.target.classList.contains('close-modal')) {
        const modal = event.target.closest('.modal');
        closeModal(modal);
        } else if (event.target.classList.contains('modal')) {
        closeModal(event.target);
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => closeModal(modal));
    }
});
  