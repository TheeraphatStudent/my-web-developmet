document.addEventListener('DOMContentLoaded', function () {
    const profileElements = document.getElementsByClassName('profileInfo');
    const displayStyle = sessionStorage.getItem('meow_account') ? 'block' : 'none';

    for (let i = 0; i < profileElements.length; i++) {
        profileElements[i].style.display = displayStyle;
    }
});