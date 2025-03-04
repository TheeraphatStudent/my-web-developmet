<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Statistic</title>
    <link rel="stylesheet" href="public/style/main.css">
</head>

<body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">
        <div class="flex gap-3 items-center">
            <h1 class="max-w-[512px] truncate font-semibold text-white">รายงานอีเวทน์</h1>
            <span class="text-md text-light-green"><?= $_GET['id'] ?? "???" ?></span>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-white text-gray-600 uppercase text-xs *:py-3 *:px-4 border-2">
                            <th class="text-left">User ID</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Age</th>
                            <th class="text-left">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white">
                        <?php if (!empty($allUserReg)): ?>
                            <?php foreach (array_reverse($allUserReg) as $item): ?>
                                <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['userId'] ?? "-" ?></td>
                                    <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= $item['name'] ?? "-" ?></td>
                                    <td class="py-3 px-4 text-left">
                                        <?= !empty($item['birth']) ? (new DateTime())->diff(new DateTime($item['birth']))->y : "-" ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= $item['status'] ?? "-" ?></td>

                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center items-center space-x-2 *:mb-0">
                                            <!-- <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1 rounded-full text-secondary hover:bg-light-secondary">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793z"></path>
                                                </svg>
                                            </a> -->
                                            <form action="..?action=request&on=reg&form=remove" method="post">
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <button class="p-1.5 rounded-full text-red hover:bg-light-red">
                                                    <img src="public/icons/reject.png" alt="reject">
                                                </button>
                                            </form>
                                            <form action="..?action=request&on=reg&form=update" class="<?= $item['status'] == "accepted" ? 'hidden' : '' ?>" method="post">
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                <input type="hidden" name="eventId" value="<?= $_GET['id'] ?>">

                                                <button class="p-1.5 rounded-full text-primary hover:bg-light-green">
                                                    <img src="public/icons/accept.png" alt="accept">
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-10 text-center text-2xl text-gray-500">ยังไม่มีผู้เข้าร่วมกิจกรรมในขณะนี้</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>

            </div>

            <div class="bg-white px-4 py-3 flex items-center justify-between border-2">
                <!-- <div class="flex items-center text-sm text-darbg-dark-primary0">
                    Showing <span class="font-medium mx-1">1</span> to <span class="font-medium mx-1">4</span> of <span class="font-medium mx-1">12</span> entries
                </div> -->
                <!-- <div class="flex space-x-1">
                    <button class="">Previous</button>
                    <button class="">1</button>
                    <button class="">2</button>
                    <button class="">3</button>
                    <button class="">Next</button>
                </div> -->
            </div>
        </div>
    </div>
</body>

</html>