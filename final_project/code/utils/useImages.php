<?php

// namespace FinalProject\Utils;

function uploadFile($file, $uploadDir)
{
    if (!empty($file)) {
        $fileName = uniqid() . '_' . basename($file['name']);
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
