<?php

namespace FinalProject\View\Event;

require_once('components/tags.php');
require_once('components/breadcrumb.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\Tags;

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
                                <th class="text-left">Name</th>
                                <th class="text-left">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white">
                            <?php if (!empty($allUserAttendOnEvent)) : ?>
                                <?php foreach (array_reverse(array($allUserAttendOnEvent)) as $item): ?>
                                    <!-- <?php print_r($item); ?> -->

                                    <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                        <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['userId'] ?></td>
                                        <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['name'] ?></td>
                                        <td class="py-3 px-4 text-sm max-w-[170px]"><?= (new Tags($item['status']))->render() ?></td>
                                        <td>
                                            <div class="flex justify-center space-x-2">
                                                <form action="../?action=reques&on=Attendance&from=remove" method="POST">
                                                    <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                    <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                    <input type="hidden" name="eventId" value="<?= $item['eventId'] ?>">

                                                    <button type="button" class="p-1.5 rounded-full text-red hover:bg-light-red <?= $item['status'] == "reject" ? 'hidden' : '' ?>" id="reject">
                                                        <img src="public/icons/reject.png" alt="reject">
                                                    </button>
                                                </form>

                                                <form action="../?action=reques&on=Attendance&from=update" method="POST">
                                                    <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                    <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                    <input type="hidden" name="eventId" value="<?= $item['eventId'] ?>">

                                                    <button type="submit" class="p-1.5 rounded-full text-primary hover:bg-light-green">
                                                        <img src="public/icons/accept.png" alt="accept">
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="py-10 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-lg mb-3 text-gray-500">ยังไม่มีผู้ผ่านการยอมรับการเข้าร่วมกิจกรรม</span>
                                            <a href="../?action=event.statistic&id=<?= $_GET['id'] ?>" class="text-primary hover:text-primary/80 font-semibold text-3xl underline decoration-primary">
                                                อนุมัติผู้เข้าร่วมตอนนี้?
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</body>

</html>