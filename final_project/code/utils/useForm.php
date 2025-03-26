<?php

function saveFormScript()
{
    return '
    async function saveForm(type) {
        let form = document.getElementById("form-content");
        let formData = new FormData(form);
        let data = {};
        let isSaved = true;

        formData.forEach((value, key) => {
            if (["cover", "more_pic[]", "description"].includes(key)) {
                isSaved = false;
            } else {
                data[key] = value;
            }
        });

        if (isSaved) {
            localStorage.setItem(type + "_formData", JSON.stringify(data));
        }

        return isSaved;
    }
    ';
}

function loadFormScript()
{
    return '
    function loadForm(type) {
        let savedData = localStorage.getItem(type + "_formData");
        if (savedData) {
            let form = document.getElementById("form-content");
            let data = JSON.parse(savedData);

            for (let key in data) {
             if (["cover", "more_pic[]", "description"].includes(key)) continue;

                let element = form.querySelector("[name=\'" + key + "\']");
                if (element) {
                    element.value = data[key];
                }
            }
        }
    }
    ';
}

function clearFormScript()
{
    return '
    function clearForm(type) {
        localStorage.removeItem(type + "_formData");
    }
    ';
}
