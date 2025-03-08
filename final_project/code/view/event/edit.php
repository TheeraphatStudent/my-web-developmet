<?php

namespace FinalProject\View\Event;

require_once('components/map/map.php');
require_once('components/texteditor/texteditor.php');
require_once('utils/useImages.php');
require_once('components/breadcrumb.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\Map;
use FinalProject\Components\TextEditor;

$map = new Map();
$map->setDefaultLocation($lat, $lon);

$textEditor = new TextEditor();
$textEditor->updatetextarea(description: $eventObj['description'], isEdit: true);

// ===================== ฺBreadcrumb =====================

$navigate = new Breadcrumb();

$navigate->setPath(
    data: ['Dashboard', 'แก้ไขกิจกรรม', $_GET['id'] ?? "???"],
    prevPath: '?action=event.manage'
);

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
    <title>Edit event</title>
</head>

<body class="bg-primary">
    <div class="flex flex-col justify-center items-center gap-12 pt-[200px] px-10 pb-[200px] w-full h-fit">
        <!-- Form Content -->
        <form
            id="form-content"
            action="../?action=request&on=event&form=update"
            class="flex flex-col w-full max-w-content h-fit gap-8"
            method="post"
            enctype="multipart/form-data">
            <!-- <input type="hidden" name="test" value="test"> -->
            <input type="text" name="eventId" class="hidden" value="<?= $eventId ?>">

            <!-- <h1 class="text-white font-semibold">Edit Event</h1> -->
            <?php $navigate->render(); ?>

            <!-- <?php print_r($eventObj) ?> -->

            <div class="flex flex-col md:flex-row justify-between items-start w-full gap-12 *:flex *:flex-col">

                <div class="justify-start items-start w-full gap-5">
                    <div class="flex flex-col w-full justify-start items-start gap-2.5">
                        <div
                            class="form-title">
                            Title&nbsp;
                            <span class="form-required">*</span>
                        </div>
                        <input required
                            class="input-field" name="title" placeholder="Enter event title" value="<?php echo htmlspecialchars($eventObj['title']) ?>">
                    </div>
                    <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Venue&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <input required
                                class="input-field" type="text" name="venue" placeholder="Enter venue" value="<?php echo htmlspecialchars($eventObj['venue']) ?>">

                        </div>
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Maximum&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <input required
                                class="input-field" type="text" name="maximum" placeholder="Enter maximum" value="<?php echo htmlspecialchars($eventObj['maximum']) ?>">

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
                                class="input-field" name="link" type="text" placeholder="Enter link" value="<?php echo htmlspecialchars($eventObj['link']) ?>">

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
                                    <input class="input-field" type="datetime-local" name="start[]" placeholder="Enter started time">
                                </div>
                                <div class="flex flex-col w-1/2 gap-2.5">
                                    <div class="form-title">
                                        End&nbsp;
                                        <span class="form-required">*</span>
                                    </div>
                                    <div class="flex w-full gap-2.5">
                                        <input class="input-field w-full" type="datetime-local" name="end[]" placeholder="Enter ended time">
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

                    <!-- <div class="flex flex-row w-full justify-start items-start gap-5 ">
                        <div class="flex flex-col w-full gap-2.5">
                            <div
                                class="form-title">
                                Authors&nbsp;
                                <span class="form-required">*</span>
                            </div>
                            <select name="authors[]" class="input-field h-32" multiple id="author-selected">
                                <?php foreach ($authors as $option): ?>
                                    <option value="<?= $option['value'] ?>"><?= $option['label'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div> -->
                </div>

                <!-- <div class="justify-start items-start w-full">
                    <div class="flex flex-col w-full justify-start items-start gap-5">
                        <div
                            class="form-title">
                            Location&nbsp;
                        </div>
                        <?php
                        $map->render();
                        ?>
                    </div>
                </div> -->
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
                    <input required type="file" accept=".png, .jpg, .jpeg" id="cover_img" name="cover" class="hidden">
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

            <div class="flex w-full justify-start items-start gap-5">
                <button type="button" class="w-1/3 btn-danger">Cancel</button>
                <button type="submit" class="w-full btn-secondary">Update</button>
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

    <!-- Date Time -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('datetime-container');

            const addButton = document.getElementById('add-datetime');
            const delButton = document.getElementById('deleted-datetime');

            const newDateTimeSet = document.createElement('div');
            addButton.addEventListener('click', () => {
                newDateTimeSet.className = 'flex flex-row w-full justify-start items-start gap-5 added-field';
                newDateTimeSet.innerHTML = `
                <div class="flex flex-col w-full">
                    <input class="input-field start-field" type="datetime-local" name="start[]" placeholder="Enter started time">
                </div>
                <div class="flex flex-col w-full">
                    <input class="input-field end-field" type="datetime-local" name="end[]" placeholder="Enter ended time">
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

                    lastField.addEventListener('transitionend', handler = () => {
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
        document.addEventListener('DOMContentLoaded', async () => {
            <?php echo (fetchBlobFunc()) ?>
            const getFileInputFromUrl = async (fileUrl) => {
                // console.log('Get File Input Work');

                try {
                    const response = await fetch(fileUrl);
                    const blob = await response.blob();
                    const file = new File([blob], fileUrl.split("/").pop(), {
                        type: blob.type
                    });

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    return dataTransfer.files;
                } catch (error) {
                    console.error('Error fetching default file: ', error);
                    return null;
                }
            };

            // Cover Img

            const defaultImageUrl = "public/images/uploads/";
            const coverPath = `${defaultImageUrl}<?= $eventObj['cover'] ?>`;

            const coverInput = document.getElementById('cover_img');
            // const coverField = document.getElementById('coverImgField');
            const coverPreview = document.getElementById('cover_label');
            // console.log(`${defaultImageUrl}<?= $eventObj['cover'] ?>`);

            if (coverPreview) {
                coverPreview.style.backgroundImage = `url(${coverPath})`;

            }

            if (coverInput) {
                coverInput.files = await getFileInputFromUrl(coverPath);

                coverInput.addEventListener('change', async function(event) {
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
                <?php if (!empty(json_decode($eventObj['morePics'], true))) : ?>
                    <?php foreach (json_decode($eventObj['morePics'], true) as $item) : ?>
                        createImagePreviewByUrl(`${defaultImageUrl}<?= htmlspecialchars($item) ?>`);
                    <?php endforeach; ?>
                <?php endif; ?>

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
                                // morePicInput.value=uploadedImages

                                // const index=uploadedImages.length - 1;
                                // createImagePreview(blobUrl, index);
                                createImagePreview(blobUrl, `more-${file.name}`);
                            };

                            reader.readAsDataURL(file);
                        }
                    }

                    // imageInput.value='' ;
                });

            }

            async function createImagePreviewByUrl(url) {
                const fileInput = await getFileInputFromUrl(url);
                const imagePreviewWrapper = createImagePreviewWrapper(url, fileInput);
                container.appendChild(imagePreviewWrapper);
            }

            async function createImagePreview(blob, fileName) {
                const fileInput = await fetchBlobFile(blob, fileName);
                const imagePreviewWrapper = createImagePreviewWrapper(blob, fileInput);
                container.appendChild(imagePreviewWrapper);
            }

            function createImagePreviewWrapper(imageUrl, fileInput) {
                const wrapper = document.createElement("div");
                wrapper.className = "relative min-w-80 min-h-[180px] rounded-2xl overflow-hidden group bg-dark-primary";

                const image = document.createElement("div");
                image.className = "w-full h-full bg-cover bg-center";
                image.style.backgroundImage = `url('${imageUrl}')`;

                const overlay = document.createElement("div");
                overlay.className = "absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300";

                const deleteButton = document.createElement("button");
                deleteButton.type = "button";
                deleteButton.className = "absolute top-2 right-2 bg-light-red text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300";

                const deleteIcon = document.createElement("img");
                deleteIcon.src = "public/icons/delete.svg";
                deleteButton.appendChild(deleteIcon);

                deleteButton.onclick = () => wrapper.remove();

                const inputField = document.createElement("input");
                inputField.type = "file";
                inputField.name = "more_pic[]";
                inputField.className = "hidden";
                inputField.files = fileInput;

                wrapper.append(image, overlay, deleteButton, inputField);

                return wrapper;
            }


            function removeImage(index) {
                const elementToRemove = document.querySelector(`[data-index="${index}" ]`);

                if (elementToRemove) {
                    elementToRemove.remove();
                }
            }
        });
    </script>
</body>

</html>