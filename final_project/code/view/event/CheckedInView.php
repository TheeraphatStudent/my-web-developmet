<?php

namespace FinalProject\View\Event;

require_once('components/breadcrumb.php');
require_once('components/camera/camera.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\QrCodeReader;

$navigate = new Breadcrumb();

$navigate->setPath(['Dashboard', 'ตรวจคนเข้างาน', 'AG-25T000001']);

$qrreader = new QrCodeReader();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Barrier</title>
</head>

<body class="bg-primary flex flex-col justify-center items-center gap-12 pt-[200px] pr-10 pb-[200px] pl-10 w-full h-full">
    <div class="flex flex-col gap-10 w-full max-w-content">
        <?php
        $navigate->render();
        // $qrreader->render();
        ?>
        <body class="flex flex-col justify-start items-center bg-primary">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-white text-gray-600 uppercase text-xs *:py-3 *:px-4 border-2">
                            <th class="text-left">User ID</th>
                            <th class="text-left">name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white">
                    <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                <td class="py-3 px-4 text-sm max-w-[170px]">hello</td>
                                <td class="py-3 px-4 text-sm max-w-[170px]">world</td>
                                <td>
                                    <div class="flex justify-center space-x-2">
                                        <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php foreach (array_reverse($allEvents) as $item): ?>
                            <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['userId'] ?></td>
                                <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['username'] ?></td>
                                <td>
                                    <div class="flex justify-center space-x-2">
                                        <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

</body>
</html>