document.addEventListener('DOMContentLoaded', function () {
    // Class : many
    // Id : single
    const displayNameElements = document.getElementsByClassName('display_username');
    const passwordElements = document.getElementsByClassName('display_password');
    const userIdElements = document.getElementsByClassName('display_user_id');
    const profileElements = document.getElementsByClassName('display_profile_picture');
    const telnoElements = document.getElementsByClassName('display_telno');
    const birthdayElements = document.getElementsByClassName('display_birthday');
    const genderElements = document.getElementsByClassName('display_gender');

    // Session
    const meowAccount = JSON.parse(sessionStorage.getItem('meow_account'));
    console.log(meowAccount)

    for (let i = 0; i < displayNameElements.length; i++) {
        if (displayNameElements[i].tagName.toLowerCase() == 'span') {
            displayNameElements[i].textContent = meowAccount?.username ?? 'undefined';

        } else {
            displayNameElements[i].value = meowAccount?.username ?? 'undefined';

        }

    }

    for (let j = 0; j < passwordElements.length; j++) {
        passwordElements[j].value = meowAccount?.password ?? 'undefined';
    }

    for (let k = 0; k < userIdElements.length; k++) {
        userIdElements[k].value = meowAccount?.userId ?? 'undefined';
    }

    for (let l = 0; l < profileElements.length; l++) {
        profileElements[l].src = meowAccount?.profileImg ?? 'https://img.freepik.com/free-vector/404-error-with-cute-animal-concept-illustration_114360-1880.jpg?t=st=1734321722~exp=1734325322~hmac=b0c78807832a186943e4b904c0923b6e8f43e7b4e8b4cd9befe316447c31a5a6&w=826';
    }

    for (let n = 0; n < telnoElements.length; n++) {
        telnoElements[n].value = meowAccount?.telno ?? 'undefined';

    }

    for (let m = 0; m < birthdayElements.length; m++) {
        birthdayElements[m].value = meowAccount?.birthday ?? 'undefined';

    }

    for (let o = 0; o < genderElements.length; o++) {
        genderElements[o].value = meowAccount?.gender ?? 'none';
    }
});