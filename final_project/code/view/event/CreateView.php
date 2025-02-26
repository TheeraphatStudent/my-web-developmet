<?php

namespace FinalProject\View\Event;

require_once('components/map/map.php');
require_once('components/texteditor/texteditor.php');

use FinalProject\Components\Map;
use FinalProject\Components\TextEditor;

$map = new Map($mapApiKey);
$textEditor = new TextEditor();

// ===================== Data =====================

$form_type = ['onsite', 'online', 'any'];
$users_mock = [
    [
        'id' => '1',
        'name' => 'User1'
    ],
    [
        'id' => '2',
        'name' => 'User2'
    ],
    [
        'id' => '3',
        'name' => 'User3'
    ],
];

$formOptions = array_map(function ($type) {
    return [
        'value' => htmlspecialchars($type),
        'label' => htmlspecialchars($type)
    ];
}, $form_type);

$authors = array_map(function ($type) {
    return [
        'value' => htmlspecialchars($type['id']),
        'label' => htmlspecialchars($type['name'])
    ];
}, $users_mock);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Create event</title>
</head>

<body class="bg-primary">
    <div class="flex flex-col justify-center items-center gap-12 pt-[200px] pr-10 pb-[200px] pl-10 w-full h-fit">
        <!-- Form Content -->
        <form action="../?action=request&on=event&form=create" class="flex flex-col w-full max-w-content h-fit gap-8" method="post">
            <h1 class="text-white font-semibold">Create Event</h1>

            <div class="flex flex-col md:flex-row justify-between items-start w-full gap-12 *:flex *:flex-col">

                <div class="justify-start items-start w-full gap-5">
                    <div class="flex flex-col w-full justify-start items-start gap-2.5">
                        <div
                            class="form-title">
                            Title&nbsp;
                            <span class="form-required">*</span>
                        </div>
                        <input
                            class="form-input" name="title" placeholder="Enter event title">
                    </div>
                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Venue&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <input
                                class="form-input" type="text" name="venue" placeholder="Enter venue">

                        </div>
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Maximum&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <input
                                class="form-input" type="text" name="maximum" placeholder="Enter maximum">

                        </div>
                    </div>

                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Type&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <!-- <input class="form-input" type="" name="venue" placeholder="Enter venue"> -->
                            <select name="type" class="form-input">
                                <?php foreach ($formOptions as $option): ?>
                                    <option value="<?= $option['value'] ?>"><?= $option['label'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Link&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <input
                                class="form-input" name="link" type="number" placeholder="Enter link">

                        </div>
                    </div>

                    <div class="flex flex-col w-full justify-start items-start gap-2.5" id="datetime-container">
                        <div class="flex flex-row w-full justify-start items-start gap-5">
                            <div class="flex w-full gap-5">
                                <div class="flex flex-col w-1/2 gap-2.5">
                                    <div class="form-title">
                                        Start&nbsp;
                                        <span class="form-required">*</span>
                                    </div>
                                    <input class="form-input" type="datetime-local" name="start[]" placeholder="Enter started time">
                                </div>
                                <div class="flex flex-col w-1/2 gap-2.5">
                                    <div class="form-title">
                                        End&nbsp;
                                        <span class="form-required">*</span>
                                    </div>
                                    <div class="flex w-full gap-2.5">
                                        <input class="form-input w-full" type="datetime-local" name="end[]" placeholder="Enter ended time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex w-full gap-5 *:flex">
                        <button type="button" id="add-datetime" class="justify-center w-full bg-light-secondary text-secondary px-4 py-2 rounded active:bg-dark-secondary hover:bg-dark-secondary/80">
                            <span class="flex items-center justify-center gap-3">
                                <img src="public/icons/added.svg" alt="add icon" width="15" height="15">
                                Date
                            </span>
                        </button>
                        <button type="button" id="deleted-datetime" class="justify-center w-full bg-light-red text-red px-4 py-2 rounded active:bg-dark-red hover:bg-dark-red/80">
                            <span class="flex items-center justify-center gap-3">
                                <img src="public/icons/delete.svg" alt="del icon" width="15" height="15">
                                Delete
                            </span>
                        </button>
                    </div>

                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Authors&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <select name="authors[]" class="form-input h-32" multiple id="author-selected">
                                <?php foreach ($authors as $option): ?>
                                    <option value="<?= $option['value'] ?>"><?= $option['label'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="justify-start items-start w-full">
                    <div class="flex flex-col w-full justify-start items-start gap-2.5">
                        <div
                            class="form-title">
                            Location&nbsp;
                        </div>
                        <?php
                        $map->render();
                        ?>
                        <input type="hidden" name="location">
                    </div>
                </div>
            </div>

            <h1 class="text-white font-semibold">Event description</h1>

            <div class="flex flex-col w-full justify-start items-start gap-5">
                <!-- <canvas></canvas> -->
                <div
                    class="form-title">
                    Cover&nbsp;
                    <span class="form-required">*</span>
                </div>
                <label id="cover_label" for="cover_img" class="bg-cover flex relative flex-col items-center justify-center w-full h-[450px] gap-2.5 bg-black/55 p-4 group hover:cursor-pointer rounded-xl overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>

                    <img id="upload_icon" src="public/icons/upload.svg" alt="upload image"
                        class="uploaded-img-icon w-12 h-12 opacity-50 group-hover:opacity-100 transition-opacity duration-300 z-10 relative">
                    <span id="upload_text" class="underline cursor-pointer font-medium text-base text-white group-hover:text-white z-10 relative transition-colors duration-300">
                        Upload Profile
                    </span>
                    <input type="file" accept=".png, .jpg, .jpeg" id="cover_img" class="hidden">
                    <input type="text" name="cover" id="coverImgField" class="hidden">

                </label>
            </div>
            <div class="flex flex-col w-full justify-start items-start gap-5">
                <!-- <canvas></canvas> -->
                <div
                    class="form-title">
                    Description&nbsp;
                    <span class="form-required">*</span>
                </div>
                <?php $textEditor->render() ?>
            </div>

            <div class="flex flex-col w-full justify-start items-start gap-5">
                <button type="submit">Create Event</button>

            </div>

        </form>

    </div>

    <!-- Date Time -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('datetime-container');
            const addButton = document.getElementById('add-datetime');
            const delButton = document.getElementById('deleted-datetime');

            addButton.addEventListener('click', () => {
                const newDateTimeSet = document.createElement('div');
                newDateTimeSet.className = 'flex flex-row w-full justify-start items-start gap-5 added-field';
                newDateTimeSet.innerHTML = `
                <div class="flex flex-col w-full">
                    <input class="form-input start-field" type="datetime-local" name="start[]" placeholder="Enter started time">
                </div>
                <div class="flex flex-col w-full">
                    <input class="form-input end-field" type="datetime-local" name="end[]" placeholder="Enter ended time">
                </div>
            `;

                container.appendChild(newDateTimeSet);

                newDateTimeSet.offsetHeight;
                newDateTimeSet.classList.add('show');
            });

            delButton.addEventListener('click', () => {
                const addedContent = document.getElementsByClassName('added-field');
                if (addedContent.length > 0) {
                    const lastField = addedContent[addedContent.length - 1];

                    lastField.classList.remove('show');

                    lastField.addEventListener('transitionend', function handler() {
                        container.removeChild(lastField);
                        lastField.removeEventListener('transitionend', handler);
                    });
                }
            });
        });
    </script>

    <!-- Multi Selected Option -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const multiSelect = document.getElementById('author-selected');

            multiSelect.addEventListener('mousedown', function(e) {
                e.preventDefault();

                const option = e.target;
                if (option.tagName === 'OPTION') {
                    option.selected = !option.selected;

                    const event = new Event('change');
                    this.dispatchEvent(event);
                }
            });

            multiSelect.addEventListener('change', function(e) {
                const selectedOptions = Array.from()
                    .map(option => option.value);

                console.log('Selected values:', selectedOptions);
            });
        });
    </script>

    <!-- Image input -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const coverInput = document.getElementById('cover_img');
            const coverField = document.getElementById('coverImgField');

            if (!coverInput) return;

            coverInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                // console.log(file);

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // console.log(e.target.result);
                        const value = e.target.result;

                        const coverImg = document.getElementById('cover_label');

                        if (coverImg) {
                            coverImg.style.backgroundImage = `url('${value}')`;
                            // console.log(`url('${value}')`)
                            coverField.value = value;
                            console.log(coverField.value)

                        }
                    };

                    reader.readAsDataURL(file);
                }
            });
        })
    </script>
</body>

</html>