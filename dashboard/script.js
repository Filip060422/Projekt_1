const wrapped = document.querySelectorAll('.plus');
wrapped.forEach(element => {
    element.addEventListener('click', () =>{
        element.classList.toggle('minus');
        element.closest('tr').nextElementSibling.classList.toggle('none');
    })
});

function submitForm() {
    document.getElementById("myForm").submit();
}

const buttonUsers = document.querySelector('.button-users');
const buttonWinners = document.querySelector('.button-winners');

buttonUsers.addEventListener('click', () => {
    document.querySelector('.winners-container').classList.add('none');
    document.querySelector('.winners-container').classList.remove('none');
    buttonUsers.classList.add('button-margin');
    buttonWinners.classList.remove('button-margin');
})

buttonWinners.addEventListener('click', () => {
    document.querySelector('.users-container').classList.remove('none');
    document.querySelector('.users-container').classList.add('none');
    buttonUsers.classList.remove('button-margin');
    buttonWinners.classList.add('button-margin');
})