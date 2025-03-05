<?php

namespace FinalProject\View\Event;

require_once('components/breadcrumb.php');

use FinalProject\Components\Breadcrumb;
$navigate = new Breadcrumb();

$navigate->setPath(
    data: ['Dashboard', 'ตรวจคนเข้างาน', $_GET['id']],
    prevPath: '?action=event.manage'
);

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
                            <?php foreach (array_reverse([]) as $item): ?>
                                <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['userId'] ?></td>
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['username'] ?></td>
                                    <td>

                                        <div class="flex justify-center space-x-2">
                                            <form action="../?action=reques&on=Attendance&from=remove" method="POST">
                                                <!-- เอาคำขอออก-->
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <button class="p-1.5 rounded-full text-red">
                                                    <img src="public/images/remove.png" width="30px" height="30px">
                                                </button>
                                            </form>

                                            <form action="../?action=reques&on=Attendance&from=update" method="POST">
                                                <!-- รับคนเข้ากิจกรรม -->
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                <input type="hidden" name="eventId" value="<?= $item['eventId'] ?>">

                                                <button class="p-1.5 rounded-full text-red">
                                                    <img src="public/images/accept.png" alt="" width="30px" height="30px">
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="7" class="py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-lg mb-3">ยังไม่มีผู้เข้าร่วมกิจกรรมในขณะนี้</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</body>

</html>