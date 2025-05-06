const email = document.getElementById('sign-in-email');
const pass = document.getElementById('sign-in-pass');
const loginBtn = document.getElementById('sign-in-btn');
const regex = /^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/;
// Normal Email
// /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
const incorrectText = document.getElementById('incorret-format');
const incorretText = document.getElementById('reg-incorrect-format');
const emptyPass = document.getElementById('empty-pass');
const regBtn = document.getElementById('sign-up-btn');
const regEmail = document.getElementById('reg-email');
const regPass = document.getElementById('reg-pass');
const regRePass = document.getElementById('reg-re-pass');
const regIncorrect = document.getElementById('reg-incorrect-format');
const regEmpty = document.getElementById('reg-empty-pass');
const regLess = document.getElementById('reg-less-pass');
const regMatch = document.getElementById('reg-match-pass');
const regReEmpty = document.getElementById('reg-re-empty-pass');
const regReLess = document.getElementById('reg-re-less-pass');
const regReMatch = document.getElementById('reg-re-match-pass');

const createAccBtn = document.getElementById('create-account');
const signUpContainer = document.getElementById('sign-up-container');
const backSignIn = document.getElementById('back-sign-in');
const signInContainer = document.getElementById('sign-in-container');
const signInParagraph = document.getElementById('sign-in-paragraph');

createAccBtn.addEventListener('click', () => {
    if (signUpContainer.style.display == 'none') {
        signUpContainer.style.display = 'flex';
        signInContainer.style.display = 'none';
        signInParagraph.innerHTML = 'Register to modify, create and share <br>exciting news and posts';
    }
});

backSignIn.addEventListener('click', () => {
    if (signInContainer.style.display == 'none') {
        signInContainer.style.display = 'flex';
        signUpContainer.style.display = 'none';
        signInParagraph.innerHTML = 'Sign in to modify, create and share <br>exciting news and posts';
        regEmail.value = '';
        regEmail.style.border = '1px solid #fcb404';
        regPass.value = '';
        regPass.style.border = '1px solid #fcb404';
        regRePass.value = '';
        regRePass.style.border = '1px solid #fcb404';
        incorretText.style.display = 'none';
        regEmpty.style.display = 'none';
        regLess.style.display = 'none';
        regMatch.style.display = 'none';
        regReEmpty.style.display = 'none';
        regReLess.style.display = 'none';
        regReMatch.style.display = 'none';
    }
});

email.addEventListener('change', () => {
    if (regex.test(email.value)) {
        email.style.border = '1px solid #fcb404'
        incorrectText.style.display = 'none';
    }
});

pass.addEventListener('change', () => {
    if (pass.value) {
        pass.style.border = '1px solid #fcb404'
        emptyPass.style.display = 'none';
    }
});

loginBtn.addEventListener('click', () => {
    let validated = true;

    if (!regex.test(email.value)) {
        validated = false;
        email.style.border = '1px solid red';
        incorrectText.style.display = 'block';
    } else {
        email.style.border = '1px solid #fcb404'
        incorrectText.style.display = 'none';
    }

    if (!pass.value) {
        pass.style.border = '1px solid red';
        emptyPass.style.display = 'block';
        validated = false;
    } else {
        pass.style.border = '1px solid #fcb404'
        emptyPass.style.display = 'none';
    }

    if (validated == true) {
        $.ajax({
            url: 'php-backend/account-validator.php',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email.value,
                pass: pass.value
            },
            success: (res) => {
                if (res.user.length != 0) {
                    const user = res.user[0];
                    console.log(user.user_id + user.user_name + user.user_email + user.user_pass);
                    alert('Success!');
                } else {
                    alert('There is something wrong with email or password.');
                    email.style.border = '1px solid red';
                    pass.style.border = '1px solid red';
                }
            },
            error: (error) => {
                alert(error);
            }
        });
    }
});

regEmail.addEventListener('change', () => {
    if (regex.test(regEmail.value)) {
        regEmail.style.border = '1px solid #fcb404'
        incorretText.style.display = 'none';
    }
});

regPass.addEventListener('change', () => {
    if (regPass.value || regPass.value.length >= 8 || regPass.value == regRePass.value) {
        regPass.style.border = '1px solid #fcb404'
        regEmpty.style.display = 'none';
        regLess.style.display = 'none';
        regMatch.style.display = 'none';
    }
});


regRePass.addEventListener('change', () => {
    if (regRePass.value || regRePass.value.length >= 8 || regPass.value == regRePass.value) {
        regRePass.style.border = '1px solid #fcb404'
        regReEmpty.style.display = 'none';
        regReLess.style.display = 'none';
        regReMatch.style.display = 'none';
    }
});

regBtn.addEventListener('click', () => {
    let validated = true;

    if (!regex.test(regEmail.value)) {
        validated = false;
        regEmail.style.border = '1px solid red';
        incorretText.style.display = 'block';
    } else {
        regEmail.style.border = '1px solid #fcb404'
        incorretText.style.display = 'none';
    }

    // Empty Pass
    if (!regPass.value || !regRePass.value) {
        regPass.style.border = '1px solid red';
        regRePass.style.border = '1px solid red';
        regEmpty.style.display = 'block';
        regReEmpty.style.display = 'block';
        validated = false;
    } else {
        regPass.style.border = '1px solid #fcb404'
        regRePass.style.border = '1px solid #fcb404';
        regEmpty.style.display = 'none';
        regReEmpty.style.display = 'none';
    }

    // Pass Less than 8
    if ((regPass.value == regRePass.value) && regPass.value.length < 8 || regRePass.value.length < 8) {
        regPass.style.border = '1px solid red';
        regRePass.style.border = '1px solid red';
        regLess.style.display = 'block';
        regReLess.style.display = 'block';
        validated = false;
    } else {
        regPass.style.border = '1px solid #fcb404';
        regRePass.style.border = '1px solid #fcb404';
        regLess.style.display = 'none';
        regReLess.style.display = 'none';
        validated = false;
    }

    if (validated == true) {
        console.log('valid');
    } else {
        console.log('invalid');
    }

    // Pass Does Not Match
    if (regPass.value != regRePass.value) {
        regPass.style.border = '1px solid red';
        regRePass.style.border = '1px solid red';
        regMatch.style.display = 'block';
        regReMatch.style.display = 'block';
        validated = false;
    } else {
        regPass.style.border = '1px solid #fcb404';
        regRePass.style.border = '1px solid #fcb404';
        regMatch.style.display = 'none';
        regReMatch.style.display = 'none';
        validated = false;
    }
});