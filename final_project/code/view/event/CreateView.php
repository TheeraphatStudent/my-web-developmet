<?php

namespace FinalProject\View\Event;

require_once('components/map/map.php');
require_once('components/texteditor/texteditor.php');
require_once('utils/useImages.php');

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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Create event</title>
</head>

<body class="bg-primary">
    <div class="flex flex-col justify-center items-center gap-12 pt-[200px] px-10 pb-[200px] w-full h-fit">
        <!-- Form Content -->
        <form
            id="form-content"
            action="../?action=request&on=event&form=create"
            class="flex flex-col w-full max-w-content h-fit gap-8"
            method="post"
            enctype="multipart/form-data">
            <!-- <input type="hidden" name="test" value="test"> -->

            <h1 class="text-white font-semibold">Create Event</h1>

            <div class="flex flex-col justify-between items-start w-full gap-12 *:flex *:flex-col">
                <div class="justify-start items-start w-full gap-5">
                    <div class="flex flex-col w-full justify-start items-start gap-2.5">
                        <div
                            class="form-title">
                            Title&nbsp;
                            <span class="form-required">*</span>
                        </div>
                        <input required
                            class="input-field" name="title" placeholder="Enter event title" maxlength="100">
                    </div>

                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Venue&nbsp;
                                <!-- <span class="form-required">*</span> -->
                            </div>
                            <input
                                class="input-field" type="number" name="venue" placeholder="Enter venue">

                        </div>
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Maximum&nbsp;
                                <!-- <span class="form-required">*</span> -->
                            </div>
                            <input
                                class="input-field" type="number" name="maximum" placeholder="Enter maximum">

                        </div>
                    </div>

                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Type&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <!-- <input class="input-field" type="" name="venue" placeholder="Enter venue"> -->
                            <select name="type" class="input-field">
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
                                class="input-field" name="link" type="text" placeholder="Enter link">

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
                                    <input class="input-field" type="datetime-local" name="start" placeholder="Enter started time">
                                </div>
                                <div class="flex flex-col w-1/2 gap-2.5">
                                    <div class="form-title">
                                        End&nbsp;
                                        <span class="form-required">*</span>
                                    </div>
                                    <div class="flex w-full gap-2.5">
                                        <input class="input-field w-full" type="datetime-local" name="end" placeholder="Enter ended time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Location&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <textarea require minlength="20"
                                class="input-field" type="number" name="location" placeholder="Enter event location"></textarea>

                        </div>
                    </div>
                </div>

                <h1 class="text-white font-semibold">Event description</h1>

                <div class="flex flex-col w-full justify-start items-start gap-5">
                    <div class="form-title">
                        Cover&nbsp;
                        <span class="form-required">*</span>
                    </div>
                    <label id="cover_label" for="cover_img" class="bg-cover flex relative flex-col items-center justify-center w-full h-[450px] gap-2.5 bg-black/55 p-4 group hover:cursor-pointer rounded-xl overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>

                        <img id="upload_icon" src="public/icons/upload.svg" alt="upload image"
                            class="uploaded-img-icon w-12 h-12 opacity-50 group-hover:opacity-100 transition-opacity duration-300 z-10 relative">
                        <span id="upload_text" class="underline cursor-pointer font-medium text-base text-white group-hover:text-white z-10 relative transition-colors duration-300">
                            Upload Cover
                        </span>
                        <input required type="file" accept=".jpg, .jpeg, .webp" id="cover_img" name="cover" class="hidden">
                    </label>
                </div>

                <div class="flex flex-col w-full justify-start items-start gap-5">
                    <div class="form-title">
                        More pictures&nbsp;
                        <span class="form-required">*</span>
                    </div>

                    <div class="flex w-full gap-5 overflow-auto">
                        <div id="images-container" class="flex gap-4 w-fit">
                            <label id="add-image-btn" class="flex flex-col justify-center items-center gap-2.5 py-5 rounded-2xl border-white border-2 border-dashed min-w-80 min-h-[180px] shadow-sm cursor-pointer hover:bg-white/10 transition-colors">
                                <div class="flex flex-col justify-center items-center gap-2.5 w-[76px] h-20">
                                    <img
                                        width="32px"
                                        height="32px"
                                        src="public/icons/added.svg"
                                        class="filter invert"
                                        alt="add" />
                                    <div class="font-kanit text-base whitespace-nowrap text-white text-opacity-100 leading-none font-normal">
                                        Add Image
                                    </div>
                                </div>
                                <input type="file" id="image-uploads" accept=".png, .jpg, .jpeg" class="hidden" multiple>
                            </label>
                        </div>
                    </div>
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

                <div class="flex w-full justify-start items-start gap-5 flex-col md:flex-row">
                    <a href="../" id="form-cancel" class="w-full md:w-1/3 btn-danger">Cancel</a>
                    <button type="button" id="form-submit" class="w-full btn-secondary">Create Event</button>
                </div>

        </form>

    </div>

    <!-- !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

    <!-- Validate Form -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("form-content");

            const submitBtn = document.getElementById("form-submit");

            submitBtn.addEventListener("click", async () => {
                const inputs = form.querySelectorAll("input[required], textarea[required], select[required]");
                let isValid = true;
                let firstInvalidField = null;

                inputs.forEach(input => {
                    if (input.value.trim() === "") {
                        isValid = false;
                        if (!firstInvalidField) firstInvalidField = input;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        text: "กรุณาตรวจเช็คข้อมูลให้เรียบร้อยก่อนส่ง",
                    });
                    firstInvalidField.focus();
                    return;
                }

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: form.method, 
                        body: formData
                    });

                    const result = await response.json();
                    // console.log(result);

                    if (response.ok) {
                        await Swal.fire({
                            icon: "success",
                            title: "สำเร็จ",
                            text: "สร้างกิจกรรมเสร็จสิ้น!", 
                        });

                        window.location.href = `${result?.redirect}`

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "เกิดข้อผิดพลาด",
                            text: "เกิดข้อผิดพลาดในการส่งข้อมูล, ลองใหม่อีกครั้ง"
                        });
                    }
                } catch (error) {
                    console.error(error);
                    console.error(error.message);
                    Swal.fire({
                        icon: "error", 
                        title: "เกิดข้อผิดพลาด",
                        text: `${error.message || "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้, โปรดติดต่อนักพัฒนา"}`
                    });
                }
            });
        });
    </script>

    <!-- Multi Selected Option -->
    <!-- <script>
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
    </script> -->

    <!-- Image input -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php echo (fetchBlobFunc()) ?>

            // Cover Img

            const coverInput = document.getElementById('cover_img');
            // const coverField = document.getElementById('coverImgField');

            if (coverInput) {
                coverInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    // console.log(file);

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = async function(e) {
                            // console.log(e.target.result);
                            const value = e.target.result;
                            const blobUrl = byte64toBlobUrl(value, 'image/jpeg', 512);

                            const coverImg = document.getElementById('cover_label');

                            if (coverImg) {
                                coverImg.style.backgroundImage = `url('${blobUrl}')`;
                                coverInput.files = await fetchBlobFile(blobUrl, `cover-${file.name}`);
                                // console.log(`url('${value}')`)
                                // coverField.value = blobUrl;
                                // console.log(coverField.value)

                            }
                        };

                        reader.readAsDataURL(file);
                    }
                });
            }

            // Multi Images
            const imageInput = document.getElementById('image-uploads');
            // const morePicInput = document.getElementById('more-pic-field');

            const addImageBtn = document.getElementById('add-image-btn');
            const container = document.getElementById('images-container');

            // let uploadedImages = [];

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const files = e.target.files;

                    if (files && files.length > 0) {
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const imageData = e.target.result;
                                const blobUrl = byte64toBlobUrl(imageData, 'image/jpeg', 512);

                                // uploadedImages.push(blobUrl);
                                // morePicInput.value = uploadedImages

                                // const index = uploadedImages.length - 1;
                                // createImagePreview(blobUrl, index);
                                createImagePreview(blobUrl, `more-${file.name}`);
                            };

                            reader.readAsDataURL(file);
                        }
                    }

                    // imageInput.value = '';
                });

            }

            async function createImagePreview(blob, fileName) {
                // console.log(blob);

                const imagePreviewWrapper = document.createElement('div');
                imagePreviewWrapper.className = 'relative min-w-80 min-h-[180px] rounded-2xl overflow-hidden group bg-dark-primary';

                const image = document.createElement('div');
                image.className = 'w-full h-full bg-cover bg-center';
                image.style.backgroundImage = `url('${blob}')`;

                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300';

                const deleteButton = document.createElement('button');
                const deleteIcon = document.createElement('img');
                deleteIcon.src = 'public/icons/delete.svg';

                const inputField = document.createElement('input');
                inputField.type = 'file';
                inputField.name = 'more_pic[]';
                inputField.className = 'hidden';

                inputField.files = await fetchBlobFile(blob, fileName);
                // inputField.value = fileName;

                deleteButton.type = 'button';
                deleteButton.className = 'absolute top-2 right-2 bg-light-red text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300';
                deleteButton.appendChild(deleteIcon);

                deleteButton.onclick = function() {
                    imagePreviewWrapper.remove();
                };

                imagePreviewWrapper.appendChild(image);
                imagePreviewWrapper.appendChild(overlay);
                imagePreviewWrapper.appendChild(deleteButton);
                imagePreviewWrapper.appendChild(inputField);

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