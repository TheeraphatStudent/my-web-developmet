document.getElementById('default-modal').classList.add('hidden')

document.querySelectorAll('[data-modal-hide]').forEach(function (element) {
    element.addEventListener('click', function () {
        document.getElementById('default-modal').classList.add('hidden');
    });
});