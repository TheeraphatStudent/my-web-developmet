<?php

namespace FinalProject\View\Event;

require_once('components/map/map.php');
require_once('components/texteditor/texteditor.php');

use FinalProject\Components\Map;
use FinalProject\Components\TextEditor;

$map = new Map();
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

        <!-- <form enctype="multipart/form-data" action="__URL__" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input type="submit" value="Send File" />
        </form> -->

        <form
            id="form-content"
            action="../?action=request&on=event&form=create"
            class="flex flex-col w-full max-w-content h-fit gap-8"
            method="post"
            enctype="multipart/form-data">
            <input type="hidden" name="test" value="test">

            <input type="text" name="title" id="">
            
            <input type="file" name="cover" id="">
            <input type="file" name="cover2" id="coverImgField">

            <div class="flex w-full justify-start items-start gap-5">
                <button type="button" class="w-1/3 btn-danger">Cancel</button>
                <button type="submit" class="w-full btn-secondary">Create Event</button>
            </div>

        </form>

    </div>

    <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

    <!-- Validate Form -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('form-content');

            form.addEventListener('submit', () => {

            })

        });
    </script>

    <!-- Image input -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const byte64toBlobUrl = (b64Data, contentType = 'image/jpeg', sliceSize = 256) => {
                try {
                    const base64String = b64Data.split(',')[1] ?? b64Data;
                    const byteCharacters = window.atob(base64String);
                    const byteArrays = [];

                    for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                        const slice = byteCharacters.slice(offset, offset + sliceSize);
                        const byteNumbers = new Uint8Array(slice.length);

                        for (let i = 0; i < slice.length; i++) {
                            byteNumbers[i] = slice.charCodeAt(i);
                        }

                        byteArrays.push(byteNumbers);
                    }

                    const blob = new Blob(byteArrays, {
                        type: contentType
                    });
                    return URL.createObjectURL(blob);
                } catch (error) {
                    return null;
                }
            };

            // Cover Img

            const coverInput = document.getElementById('cover_img');
            const coverField = document.getElementById('coverImgField');

            if (coverInput) {
                coverInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const blobUrl = byte64toBlobUrl(e.target.result, 'image/jpeg', 512);
                            if (coverLabel) {
                                coverLabel.style.backgroundImage = `url('${blobUrl}')`;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Multi Images

            const imageInput = document.getElementById('image-upload');
            const morePicInput = document.getElementById('more-pic-field');

            const addImageBtn = document.getElementById('add-image-btn');
            const container = document.getElementById('images-container');

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const blobUrl = byte64toBlobUrl(e.target.result, 'image/jpeg', 512);
                                createImagePreview(blobUrl);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                });
            }

            function createImagePreview(imageData) {
                const imagePreviewWrapper = document.createElement('div');
                imagePreviewWrapper.className = 'relative min-w-80 min-h-[180px] rounded-2xl overflow-hidden group bg-dark-primary';

                const image = document.createElement('div');
                image.className = 'w-full h-full bg-cover bg-center';
                image.style.backgroundImage = `url('${imageData}')`;

                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300';

                const deleteButton = document.createElement('button');
                const deleteIcon = document.createElement('img');
                deleteIcon.src = 'public/icons/delete.svg';

                deleteButton.type = 'button';
                deleteButton.className = 'absolute top-2 right-2 bg-light-red text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300';
                deleteButton.appendChild(deleteIcon);

                deleteButton.onclick = function() {
                    imagePreviewWrapper.remove();
                };

                imagePreviewWrapper.appendChild(image);
                imagePreviewWrapper.appendChild(overlay);
                imagePreviewWrapper.appendChild(deleteButton);

                container.appendChild(imagePreviewWrapper);
            }

            function removeImage(index) {
                const elementToRemove = document.querySelector(`[data-index="${index}"]`);

                if (elementToRemove) {
                    elementToRemove.remove();
                }
            }
        });
    </script>
</body>

</html>