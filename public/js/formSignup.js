const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
const lengthRegex = /^.{8,}$/;
const minRegex = /(?=.*[a-z])/;
const majRegex = /(?=.*[A-Z])/;
const numberRegex = /(?=.*\d)/;
const specialCharRegex = /(?=.*[\W_])/;

const pswStrength = document.querySelector("#psw-strength");
const inputPassword = document.querySelector('#password');
const bsProgressBar = document.querySelector('.progress-bar');

const xmarkLength = document.querySelector('#xmarkLength');
const checkLength = document.querySelector('#checkLength');
const xmarkMaj = document.querySelector('#xmarkMaj');
const checkMaj = document.querySelector('#checkMaj');
const xmarkMin = document.querySelector('#xmarkMin');
const checkMin = document.querySelector('#checkMin');
const xmarkNumber = document.querySelector('#xmarkNumber');
const checkNumber = document.querySelector('#checkNumber');
const xmarkSpecialChar = document.querySelector('#xmarkSpecialChar');
const checkSpecialChar = document.querySelector('#checkSpecialChar');

const email = document.querySelector('#email');
const emailError = document.querySelector('#emailError');
const pseudo = document.querySelector('#pseudo');
const pseudoError = document.querySelector('#pseudoError');

// Ajout du gestionnaire d'évènement pour l'input
inputPassword.addEventListener("input", (event) => {
    const password = event.target.value;
    validateAll(password);
});

// Masquer icone de validation
const checkIcons = document.querySelectorAll('.fa-check');
checkIcons.forEach(checkIcon => {
    checkIcon.hidden = true;
});

// ------------------------
// validation du formulaire
// ------------------------
document.querySelector('#formSignUp').addEventListener('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    // Validation email
    if (emailRegex.test(email.value) === false) {
        emailError.textContent = "L'adresse mail n'est pas valide.";
        emailError.hidden = false;
        isValid = false;
    } else {
        emailError.hidden = true;
    }
    // Validation de la longueur du pseudo
    if (pseudo.value.length <= 3) {
        pseudoError.textContent = "Le pseudo doit contenir au moins 3 caractères";
        pseudoError.hidden = false;
        isValid = false;
    } else {
        pseudoError.hidden = true;
    }

    // Validation password
    if (!validateAll(inputPassword.value)) {
        isValid = false;
    }

    // ------------ Formulaire validé : soumission du formulaire
    validateForm(new FormData(this), isValid);
})

// --------------------------
// validation du mot de passe
// --------------------------
function validateOne(regex, password, check, xmark) {

    if (regex.exec(password)) {
        check.hidden = false;
        xmark.hidden = true;
        return 1;
    } else {
        check.hidden = true;
        xmark.hidden = false;
        return 0;
    }
}

function validateAll(password) {
    pswStrength.hidden = false;
    let res = false;
    let checkCount = 0;

    checkCount += validateOne(lengthRegex, password, checkLength, xmarkLength); // Validation de la longueur
    checkCount += validateOne(majRegex, password, checkMaj, xmarkMaj); // Présence d'une majuscule
    checkCount += validateOne(minRegex, password, checkMin, xmarkMin); // Présence d'une minuscule
    checkCount += validateOne(numberRegex, password, checkNumber, xmarkNumber); // Présence d'une chiffre
    checkCount += validateOne(specialCharRegex, password, checkSpecialChar, xmarkSpecialChar); // Présence d'un caractère spécial

    const percent = `${checkCount * 20}%`;
    bsProgressBar.style.width = percent;

    bsProgressBar.classList.remove('bg-success', 'bg-warning', 'bg-danger');

    switch (checkCount) {
        case 0:
        case 1:
        case 2:
            //red
            bsProgressBar.classList.add('bg-danger');
            break;

        case 5:
            // green
            bsProgressBar.classList.add('bg-success');
            res = true
            break;

        default:
            // orange
            bsProgressBar.classList.add('bg-warning');
            break;
    }
    return res;
};
