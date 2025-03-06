<?php

require_once('components/tags.php');
require_once('components/breadcrumb.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\Tags;

$navigate = new Breadcrumb();

$navigate->setPath(
    data: ['Dashboard', 'รายงานกิจกรรม', $_GET['id'] ?? "???"],
    prevPath: '?action=event.manage'
);


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Event</title>
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

<body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">
        <!-- <div class="flex gap-3 items-center">
            <h1 class="max-w-[512px] truncate font-semibold text-white">รายงานอีเวทน์</h1>
            <span class="text-md text-light-green"><?= $_GET['id'] ?? "???" ?></span>
        </div> -->

        <?php $navigate->render() ?>

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
                    <tbody class="divide-y divide-white" id="tbody-content">
                        <?php if (!empty($allUserReg)): ?>
                            <?php foreach (array_reverse($allUserReg) as $item): ?>
                                <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= $item['userId'] ?? "-" ?></td>
                                    <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= $item['name'] ?? "-" ?></td>
                                    <td class="py-3 px-4 text-left">
                                        <?= !empty($item['birth']) ? (new DateTime())->diff(new DateTime($item['birth']))->y : "-" ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= (new Tags($item['status']))->render() ?></td>

                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center items-center space-x-2 *:mb-0">
                                            <button type="button" class="p-1.5 rounded-full text-red hover:bg-light-red" id="reject">
                                                <img src="public/icons/reject.png" alt="reject">
                                            </button>
                                            <form action="..?action=request&on=reg&form=accept" class="<?= $item['status'] == "accepted" ? 'hidden' : '' ?>" method="post">
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                <input type="hidden" name="eventId" value="<?= $_GET['id'] ?>">

                                                <button type="submit" class="p-1.5 rounded-full text-primary hover:bg-light-green">
                                                    <img src="public/icons/accept.png" alt="accept">
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div id="rejectModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                                    <div class="bg-white rounded-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
                                        <div class="flex justify-between items-center mb-6">
                                            <h3 class="text-2xl font-semibold font-kanit text-dark-red">ปฏิเศษผู้เข้าร่วม</h3>
                                            <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <form id="rejectForm" class="flex flex-col mb-0" action="../?action=request&on=reg&form=reject" method="post">
                                            <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                            <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                            <input type="hidden" name="eventId" value="<?= $_GET['id'] ?>">

                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white relative group">
                                                    <img id="profile" class="object-cover w-full h-full" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ" alt="Profile picture">
                                                </div>
                                                <span><?= $item['name'] ?? '-' ?></span>
                                            </div>

                                            <div class="space-y-4">
                                                <label class="text-sm font-medium text-gray-700">ระบบเหตุผล</label>
                                                <textarea name="message" class="w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="(ไม่บังคับ)"></textarea>
                                            </div>

                                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                                <button type="button" id="cancelForm" class="px-4 py-2 border border-red rounded-lg text-red hover:text-white hover:bg-red/50">ยกเลิก</button>
                                                <button type="button" id="confirmForm" class="px-4 py-2 bg-dark-red text-white rounded-lg hover:bg-red">ยืนยันการปฏิเศษ</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"> </script>
    <script>
        const reject = document.getElementById('reject');
        const rejectForm = document.getElementById('rejectForm');

        const modal = document.getElementById('rejectModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        const cancelForm = document.getElementById('cancelForm')
        const confirmForm = document.getElementById('confirmForm')

        function closeModal() {
            modal.classList.add('hidden');
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        reject.addEventListener('click', () => {
            modal.classList.remove('hidden');

        })

        closeModalBtn.addEventListener('click', closeModal);
        cancelForm.addEventListener('click', closeModal);

        // =========== Submit Form ===========

        confirmForm.addEventListener('click', () => {
            const formData = new FormData(rejectForm);

            Swal.fire({
                title: 'ยืนยันการปฏิเศษ',
                text: `ผ้เข้าร่วม ${formData.get('name') ?? "-"}`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน'
            }).then((result) => {
                if (result.isConfirmed) {
                    rejectForm.submit();
                }
            });

        })
    </script>
</body>