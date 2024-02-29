let survey_buttons = document.querySelectorAll('.to_survey');
let inputs_one = document.querySelectorAll('.input_answer_one');
let inputs_two = document.querySelectorAll('.input_answer_two');
let inputs_three = document.querySelectorAll('.input_answer_three');
let images = document.querySelectorAll('.image_answer');
let button_one = document.querySelector('.submit_one');
let button_two = document.querySelector('.submit_two');
let button_three = document.querySelector('.submit_three');
let back_buttons = document.querySelectorAll('.last_question');
let span = document.querySelector('.final_result');

let points = 0;

survey_buttons.forEach(button => {
    button.addEventListener('click', () => {
        let container = document.querySelector('.container');
        let container_modal = document.querySelector('.container_modal');
        container.classList.add('none');
        container_modal.classList.remove('none');
    })
});
inputs_one.forEach(input => {
    input.addEventListener('click', () => { 
        inputs_one.forEach(input => {
            if(input.classList.contains('border')) {
                input.classList.remove('border');
                input.parentElement.firstElementChild.src="./media/flower-icon.svg";
                input.previousElementSibling.style.color = '#FFFFFF'
            }
        });
        input.classList.toggle('border');
        input.parentElement.firstElementChild.src="./media/flower-icon-color.svg";
        input.previousElementSibling.style.color = '#543E3C'
    })
});
inputs_two.forEach(input => {
    input.addEventListener('click', () => { 
        inputs_two.forEach(input => {
            if(input.classList.contains('border')) {
                input.classList.remove('border');
                input.parentElement.firstElementChild.src="./media/flower-icon.svg";
                input.previousElementSibling.style.color = '#FFFFFF'
            }
        });
        input.classList.toggle('border');
        input.parentElement.firstElementChild.src="./media/flower-icon-color.svg";
        input.previousElementSibling.style.color = '#543E3C'
    })
});
inputs_three.forEach(input => {
    input.addEventListener('click', () => { 
        inputs_three.forEach(input => {
            if(input.classList.contains('border')) {
                input.classList.remove('border');
                input.parentElement.firstElementChild.src="./media/flower-icon.svg";
                input.previousElementSibling.style.color = '#FFFFFF'
            }
        });
        input.classList.toggle('border');
        input.parentElement.firstElementChild.src="./media/flower-icon-color.svg";
        input.previousElementSibling.style.color = '#543E3C'
    })
});

button_one.addEventListener('click', () => {
    inputs_one.forEach(input => {
        if(input.classList.contains('border')) {
            let temp = 0;
            let modals = document.querySelectorAll('.modal_content');
            for(let i = 0; i < modals.length; i++) {
                if(!modals[i].classList.contains('none') && temp === 0) {
                    modals[i].classList.add('none')
                    modals[i + 1].classList.remove('none')
                    temp = 1;
                }

            }
        } 
    });
    if(!inputs_one[0].classList.contains('border') && !inputs_one[1].classList.contains('border') && !inputs_one[2].classList.contains('border')) {
        alert("Prosimy o zaznaczenie odpowiedzi!");
    } 
    if(inputs_one[2].classList.contains('border')) {
        points++;
    }
     console.log(points);
})
button_two.addEventListener('click', () => {
    inputs_two.forEach(input => {
        if(input.classList.contains('border')) {
            let temp = 0;
            let modals = document.querySelectorAll('.modal_content');
            for(let i = 0; i < modals.length; i++) {
                if(!modals[i].classList.contains('none') && temp === 0) {
                    modals[i].classList.add('none')
                    modals[i + 1].classList.remove('none')
                    temp = 1;
                }
            }
        }
    });
    if(!inputs_two[0].classList.contains('border') && !inputs_two[1].classList.contains('border') && !inputs_two[2].classList.contains('border')) {
        alert("Prosimy o zaznaczenie odpowiedzi!");
    }
    if(inputs_two[1].classList.contains('border')) {
        points++;
    }
})
button_three.addEventListener('click', () => {
    inputs_three.forEach(input => {
        if(input.classList.contains('border')) {
            let temp = 0;
            let modals = document.querySelectorAll('.modal_content');
            for(let i = 0; i < modals.length; i++) {
                if(!modals[i].classList.contains('none') && temp === 0) {
                    modals[i].classList.add('none')
                    modals[i + 1].classList.remove('none')
                    temp = 1;
                }
            }
        }
    });
    if(!inputs_three[0].classList.contains('border') && !inputs_three[1].classList.contains('border') && !inputs_three[2].classList.contains('border')) {
        alert("Prosimy o zaznaczenie odpowiedzi!");
    } 
    if(inputs_three[0].classList.contains('border')) {
        points++;
    }
    console.log(points);
    span.innerText = `${points}/3`;
})

back_buttons.forEach(button => {
    button.addEventListener('click', () => {
        let temp = 0;
        let modals = document.querySelectorAll('.modal_content');
        for(let i = 0; i < modals.length; i++) {
            if(!modals[i].classList.contains('none') && temp === 0) {
                modals[i].classList.add('none')
                modals[i - 1].classList.remove('none')
                temp = 1;
            }
        }
    })
});

let check_all = document.querySelector('.check_all');
let checks = document.querySelectorAll('.check');

check_all.addEventListener('click', () => {
    checks.forEach(check => {
        if(check_all.checked === true) {
            check.checked = true;
        } else if(check_all.checked === false) {
            check.checked = false;
        }
    });
})