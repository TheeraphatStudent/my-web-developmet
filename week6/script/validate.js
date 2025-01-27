export const validateAndSubmitForm = (formId) => {
    const form = document.getElementById(formId);
    if (!form) {
        console.error(`Form with id "${formId}" not found`);
        return;
    }

    const inputs = form.querySelectorAll('input[required], select[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('border-red-500');
        } else {
            input.classList.remove('border-red-500');
        }

    });

    if (isValid) {
        form.submit();
    }
};