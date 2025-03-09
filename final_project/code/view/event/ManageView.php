<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Event</title>
    <link rel="stylesheet" href="public/style/main.css">
</head>

<body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">
        <div class="flex flex-col">
            <h1 class="text-3xl font-semibold mb-2 text-left text-white flex item-center">Welcome'&nbsp;<span class="typing-animation max-w-fit"><?= $_SESSION['user']['username'] ?? "???" ?></span></h1>
            <span class="text-white">จัดการ Event ของคุณได้ที่นี่</span>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto shadow-lg rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">
                            <th class="py-3 px-4 text-left">Event ID</th>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Maximum</th>
                            <th class="py-3 px-4 text-left">Request</th>
                            <th class="py-3 px-4 text-left">Attends</th>
                            <th class="py-3 px-4 text-left">Joined</th>
                            <th class="py-3 px-4 text-left">Created</th>
                            <th class="py-3 px-4 text-left">Started</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (!empty($allEvents)): ?>
                            <?php foreach (array_reverse($allEvents) as $item): ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="py-3 px-4 text-sm"><?= $item['eventId'] ?></td>
                                    <td class="py-3 px-4 text-sm font-medium"><?= $item['title'] ?></td>
                                    <td class="py-3 px-4 text-center"><?= $item['maximum'] ?></td>
                                    <td class="py-3 px-4 text-center"><?= $item['request'] ?></td>
                                    <td class="py-3 px-4 text-center"><?= $item['attendee'] ?></td>
                                    <td class="py-3 px-4 text-center"><?= $item['joined'] ?></td>
                                    <td class="py-3 px-4 text-sm"><?= $item['created'] ?></td>
                                    <td class="py-3 px-4 text-sm"><?= $item['start'] ?></td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1.5 rounded-full text-secondary hover:bg-light-secondary">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </a>
                                            <a href="../?action=event.statistic&id=<?= $item['eventId'] ?>" class="p-1.5 rounded-full hover:bg-light-yellow">
                                                <svg height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 57.924 57.924" xml:space="preserve" fill="#F4B028" stroke="#F4B028" stroke-width="0.0005792400000000001">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.23169599999999999"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path style="fill:#F4B028;" d="M31,26.924h26.924C56.94,12.503,45.421,0.983,31,0V26.924z"></path>
                                                            <path style="fill:#F4B028;" d="M50.309,48.577c4.343-4.71,7.151-10.858,7.614-17.653H32.656L50.309,48.577z"></path>
                                                            <path style="fill:#F4B028;" d="M27,30.924V0C11.918,1.028,0,13.58,0,28.924c0,16.016,12.984,29,29,29 c6.99,0,13.396-2.479,18.401-6.599L27,30.924z"></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>
                                            <a href="../?action=event.checked-in&id=<?= $item['eventId'] ?>" class="p-1.5 rounded-full hover:bg-light-green">
                                                <svg viewBox="0 0 24 24" height="20px" width="20px" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path d="M14 19.2857L15.8 21L20 17M4 21C4 17.134 7.13401 14 11 14C12.4872 14 13.8662 14.4638 15 15.2547M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z" stroke="#226E6A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                            <!-- <button class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </button>
                                            <button class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </button>
                                            <button class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </button> -->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-lg mb-3 text-gray-500">ยังไม่มีกิจกรรมที่คุณสร้าง</span>
                                        <a href="../?action=event.create" class="text-primary hover:text-primary/80 font-semibold text-3xl underline decoration-primary">
                                            สร้างกิจกรรมเลย?
                                        </a>
                                    </div>
                                </td>
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