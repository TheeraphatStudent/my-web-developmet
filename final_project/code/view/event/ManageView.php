<?php
$_GET['id'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="public/style/main.css">

    <style>
        .surprise-animation {
            animation: colorChange 3s infinite;
        }

        @keyframes colorChange {
            0% {
                background-color: rgba(59, 130, 246, 0.1);
            }

            50% {
                background-color: rgba(139, 92, 246, 0.3);
            }

            100% {
                background-color: rgba(59, 130, 246, 0.1);
            }
        }
    </style>
</head>

<body class="flex flex-col justify-center items-center bg-primary">
    <div class="w-full gap-14 max-w-content py-[200px] px-10 lg:px-0">
        <h1 class="text-2xl font-bold mb-4 text-left text-white">Welcome' [NAME]</h1>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-white text-gray-600 uppercase text-xs *:py-3 *:px-4 border-2">
                            <th class="text-left">Event ID</th>
                            <th class="text-left">Title</th>
                            <th class="text-left">Type</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Maximum</th>
                            <th class="text-left">Attendees</th>
                            <th class="text-left">Started</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white">
                        <?php foreach ($allEvents as $item): ?>
                            <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden">
                                <td class="py-3 px-4 text-sm max-w-[150px]"><?= $item['eventId']?></td>
                                <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= $item['title']?></td>
                                <td class="py-3 px-4"><span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Conference</span></td>
                                <td class="py-3 px-4"><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span></td>
                                <td class="py-3 px-4 text-center">50</td>
                                <td class="py-3 px-4 text-center">250</td>
                                <td class="py-3 px-4 text-sm">03/15/2025</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="../?action=event.edit&id=<?= $item['eventId'] ?>" class="p-1 rounded-full text-blue-600 hover:bg-blue-100">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
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