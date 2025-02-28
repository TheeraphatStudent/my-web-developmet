<?php

// namespace FinalProject\Utils;

function uploadFile($file, $uploadDir)
{
    print_r("Upload file work!");

    $fileName = uniqid() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }

    return null;
}

function uploadMultipleFiles($files, $uploadDir)
{
    $uploadedFiles = [];

    foreach ($files['name'] as $key => $name) {
        $file = [
            'name' => $files['name'][$key],
            'type' => $files['type'][$key],
            'tmp_name' => $files['tmp_name'][$key],
            'error' => $files['error'][$key],
            'size' => $files['size'][$key]
        ];

        $uploadedFile = uploadFile($file, $uploadDir);
        if ($uploadedFile) {
            $uploadedFiles[] = $uploadedFile;
        }
    }

    return $uploadedFiles;
}