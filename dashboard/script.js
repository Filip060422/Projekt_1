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