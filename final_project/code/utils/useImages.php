<?php

// namespace FinalProject\Utils;

function uploadFile($file, $uploadDir)
{
    if (!empty($file)) {
        $fileName = uniqid() . '_' . basename(trim($file['name']));
        $targetPath = rtrim($uploadDir, '/') . '/' . $fileName;

        // echo '<br>';
        // print_r($file);
        // echo '<br>';

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName;
        }
    }

    return null;
}

function uploadMultipleFiles($files, $uploadDir)
{
    $uploadedFiles = [];

    // echo 'upload multiple file work';
    // print_r($files);
    // echo '';

    foreach ($files['name'] as $key => $name) {
        $file = [
            'name' => $files['name'][$key],
            'type' => $files['type'][$key],
            'tmp_name' => $files['tmp_name'][$key],
            'error' => $files['error'][$key],
            'size' => $files['size'][$key]
        ];

        $uploadedFile = uploadFile($file, $uploadDir);
        $uploadedFiles[] = $uploadedFile;
    }

    return $uploadedFiles;
}

function fetchBlobFunc()
{
    return "
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

        const blob = new Blob(byteArrays, { type: contentType });
        return URL.createObjectURL(blob);
    } catch (error) {
        return null;
    }
};

const fetchBlobFile = async (blobUrl, fileName) => {
    const response = await fetch(blobUrl);
    const blobFile = await response.blob();

    const file = new File([blobFile], fileName, { type: blobFile.type });
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);

    return dataTransfer.files;
};

const createJpegObject = async (base64) => {
    return new Promise((resolve, reject) => {
        var img = new Image();
        img.src = base64;
        img.onload = function() {
            var canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            var ctx = canvas.getContext('2d');

            ctx.fillStyle = 'white';  // Fill background for transparency
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            ctx.drawImage(img, 0, 0);
            var jpegBase64 = canvas.toDataURL('image/jpeg', 0.9);
            resolve(jpegBase64);
        };

        img.onerror = (err) => reject(err);
    });
};
";
}

function removeFile($fileName, $saveDir)
{
    $filePath = rtrim($saveDir, '/') . '/' . $fileName;

    // print_r("Remove file work!");

    if (file_exists($filePath)) {
        unlink($filePath);
        return true;
    }

    return false;
}
