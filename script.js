const survey_buttons = document.querySelectorAll('.to-survey');
const images = document.querySelectorAll('.image-answer');
const back_buttons = document.querySelectorAll('.last-question');
const inputs_color = document.querySelectorAll('.inputs-color');
const check_all = document.querySelector('.check-all');
const checks = document.querySelectorAll('.check');
const modals = document.querySelectorAll('.modal-content');

let points = 0;

function button_click(number) {
    const alerts = document.querySelector(`.alert-${number}`);
    const alerts2 = document.querySelector(`.second-alert-${number}`);
    const inputs = document.querySelectorAll(`.input-answer-${number}`);
    inputs.forEach(input => {
        if(input.classList.contains('active-border')) {
            let temp = 0;
            for(let i = 0; i < modals.length; i++) {
                if(!modals[i].classList.contains('none') && temp === 0) {
                    modals[i].classList.add('none')
                    modals[i + 1].classList.remove('none')
                    temp = 1;
                }
            }
        }
    });
    
    if(!inputs[0].classList.contains('active-border') && !inputs[1].classList.contains('active-border') && !inputs[2].classList.contains('active-border')) {
        alerts.classList.remove('hidden');
        alerts2.classList.remove('hidden');
    } else {
        alerts.classList.add('hidden');
        alerts2.classList.add('hidden');

        points = (number === 'one' && inputs[2].classList.contains('active-border')) ? 1 : (number === 'one'? 0 : points);
        points = (number === 'two' && inputs[1].classList.contains('active-border')) ? (points >= 1 ? 2 : 1) : (number === 'two' ? (points >= 1 ? 1 : 0) : points);
        points = (number === 'three' && inputs[0].classList.contains('active-border')) ? (points >= 2 ? 3 : points == 1 ? 2 : 1) : (number === 'three' ? (points >= 2 ? 2 : points >= 1 ? 1 : 0) : points);
    }
    document.querySelector('.final-result').innerText = `${points}/3`;
    document.querySelector('.final-result-input').value = points;
}

survey_buttons.forEach(button => {
    button.addEventListener('click', () => {
        const container = document.querySelector('.container');
        const container_modal = document.querySelector('.container-modal');
        container.classList.add('none');
        container_modal.classList.remove('none');
    })
});

for(let i = 0; i<inputs_color.length; i++){
    inputs_color[i].addEventListener('click', () => {
        change_color(i <= 2 ? 'one' : (i <= 5 ? 'two' : 'three'));
        function change_color(number){
            const inputs = document.querySelectorAll(`.input-answer-${number}`);
            inputs.forEach(input => {
                    if (input.classList.contains('active-border')) {
                        input.classList.remove('active-border');
                        input.parentElement.firstElementChild.src = "./media/flower-icon.svg";
                        input.previousElementSibling.style.color = '#FFFFFF';
                    }
            });
            inputs_color[i].classList.toggle('active-border');
            inputs_color[i].parentElement.firstElementChild.src = "./media/flower-icon-color.svg";
            inputs_color[i].previousElementSibling.style.color = '#543E3C';
        }
    });
}


back_buttons.forEach(button => {
    button.addEventListener('click', () => {
        let temp = 0;
        for(let i = 0; i < modals.length; i++) {
            if(!modals[i].classList.contains('none') && temp === 0) {
                modals[i].classList.add('none')
                modals[i - 1].classList.remove('none')
                temp = 1;
            }
        }
    })
});

check_all.addEventListener('click', () => {
    checks.forEach(check => {
        if(check_all.checked === true) {
            check.checked = true;
        } else if(check_all.checked === false) {
            check.checked = false;
        }
    });
});



document.getElementById("survey-form").addEventListener("submit", function(event) {
    event.preventDefault();
            let temp = 0;
            for(let i = 0; i < modals.length; i++) {
                if(!modals[i].classList.contains('none') && temp === 0) {
                    modals[i].classList.add('none')
                    modals[i + 1].classList.remove('none')
                    temp = 1;
                }
            }
});