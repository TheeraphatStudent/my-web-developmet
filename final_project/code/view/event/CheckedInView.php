<?php

namespace FinalProject\View\Event;

require_once('components/tags.php');
require_once('components/breadcrumb.php');
require_once('utils/useDateTime.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\Tags;

$navigate = new Breadcrumb();

$navigate->setPath(
    data: ['Dashboard', 'จัดการผู้เข้าร่วม', $_GET['id']],
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

        <div style='border-bottom: 2px solid #FBF8EE'>
            <ul class='flex *:cursor-pointer *:hover:backdrop-blur-lg text-primary'>
                <li id="approved-tab" class='py-2 px-6 bg-dark-primary rounded-tl-md active-tab'>อนุมัติ</li>
                <li id="checkedin-tab" class='py-2 px-6 bg-dark-primary rounded-tr-md'>ตรวจบัตร</li>
            </ul>
        </div>

        <!-- Approved -->
        <div id="approved-table" class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-white text-gray-600 uppercase text-xs *:py-3 *:px-4 border-2">
                            <th class="text-left">User ID</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">gender</th>
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
                                    <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= $item['gender'] ?? "-" ?></td>
                                    <td class="py-3 px-4 text-left"> <?= !empty($item['birth']) ? ageCalculator(birth: $item['birth']) : "-" ?> </td>
                                    <td class="py-3 px-4 text-sm font-medium max-w-[150px]"><?= (new Tags($item['status']))->render() ?></td>
                                    <td>
                                        <div class="flex justify-center items-center space-x-2 *:mb-0">
                                            <button type="button" class="p-1.5 rounded-full text-red hover:bg-light-red <?= $item['status'] == "reject" ? 'hidden' : '' ?>" id="reject">
                                                <img class="w-4 h-4" src="public/icons/reject.png" alt="reject">
                                            </button>
                                            <form action="..?action=request&on=reg&form=accept" class="<?= $item['status'] == "accepted" ? 'hidden' : '' ?>" method="post">
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                <input type="hidden" name="eventId" value="<?= $_GET['id'] ?>">
                                                <input type="hidden" name="authorId" value="<?= $_SESSION['user']['userId'] ?>">

                                                <button type="submit" class="p-1.5 rounded-full text-primary hover:bg-light-green">
                                                    <img class="w-4 h-4" src="public/icons/accept.png" alt="accept">
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
                                            <!-- <input type="hidden" name="userId" value="<?= $item['userId'] ?>"> -->
                                            <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                            <input type="hidden" name="eventId" value="<?= $_GET['id'] ?>">

                                            <!-- <div class="flex flex-col items-center gap-3">
                                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white relative group">
                                                    <img id="profile" class="object-cover w-full h-full" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ" alt="Profile picture">
                                                </div>
                                                <span><?= $item['name'] ?? '-' ?></span>
                                            </div> -->

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
                                <td colspan="6" class="py-10 text-center text-2xl text-gray-500">ยังไม่มีผู้เข้าร่วมกิจกรรมในขณะนี้</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Checked In -->
        <div id="checkedin-table" class="bg-white rounded-lg shadow-lg overflow-hidden hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-white text-gray-600 uppercase text-xs *:py-3 *:px-4 border-2">
                            <th class="text-left">User ID</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Gender</th>
                            <th class="text-left">Age</th>
                            <th class="text-left">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white">
                        <?php if (!empty($allUserAttendOnEvent)) : ?>
                            <?php foreach (array_reverse($allUserAttendOnEvent) as $item) : ?>
                                <tr class="hover:bg-dark-primary/10 max-h-16 h-16 *:overflow-hidden *:truncate">
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= htmlspecialchars($item['userId'] ?? "-") ?></td>
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= htmlspecialchars($item['name'] ?? "-") ?></td>
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= htmlspecialchars($item['gender'] ?? "-") ?></td>
                                    <td class="py-3 px-4 text-left"> <?= !empty($item['birth']) ? ageCalculator(birth: $item['birth']) : "-" ?> </td>
                                    <td class="py-3 px-4 text-sm max-w-[170px]"><?= (new Tags($item['status']))->render() ?></td>
                                    <td>
                                        <div class="flex justify-center space-x-2">
                                            <form action="../?action=request&on=attend&from=remove" method="post">
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                <input type="hidden" name="eventId" value="<?= $item['eventId'] ?>">

                                                <button type="button" class="p-1.5 rounded-full text-red hover:bg-light-red <?= ($item['status'] == "pending") ? '' : 'hidden' ?>" id="reject">
                                                    <img class="w-4 h-4" src="public/icons/reject.png" alt="reject">
                                                </button>
                                            </form>

                                            <form action="../?action=request&on=attend&form=accept" method="post">
                                                <input type="hidden" name="userId" value="<?= $item['userId'] ?>">
                                                <input type="hidden" name="authorId" value="<?= $_SESSION['user']['userId'] ?>">
                                                <input type="hidden" name="regId" value="<?= $item['regId'] ?>">
                                                <input type="hidden" name="eventId" value="<?= $item['eventId'] ?>">

                                                <button type="submit" class="p-1.5 rounded-full text-primary hover:bg-light-green <?= $item['status'] == "accepted" ? 'hidden' : '' ?>">
                                                    <img class="w-4 h-4" src="public/icons/accept.png" alt="accept">
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
                                        <button onclick="showApprovedTable()" class="text-primary hover:text-primary/80 font-semibold text-3xl underline decoration-primary">
                                            อนุมัติผู้เข้าร่วมตอนนี้?
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Table Management -->
    <script>
        const approvedTab = document.getElementById("approved-tab");
        const checkedInTab = document.getElementById("checkedin-tab");

        const approvedTable = document.getElementById("approved-table");
        const checkedInTable = document.getElementById("checkedin-table");

        function showApprovedTable() {
            approvedTable.classList.remove("hidden");
            checkedInTable.classList.add("hidden");

            approvedTab.classList.add("active-tab");
            checkedInTab.classList.remove("active-tab");
        }

        function showCheckedInTable() {
            checkedInTable.classList.remove("hidden");
            approvedTable.classList.add("hidden");

            checkedInTab.classList.add("active-tab");
            approvedTab.classList.remove("active-tab");
        }

        approvedTab.addEventListener("click", showApprovedTable);
        checkedInTab.addEventListener("click", showCheckedInTable);
    </script>

    <!-- Reject -->
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

        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

        }

        if (reject) {
            reject.addEventListener('click', () => {
                modal.classList.remove('hidden');

            })

        }

        closeModalBtn && closeModalBtn.addEventListener('click', closeModal);
        cancelForm && cancelForm.addEventListener('click', closeModal);

        // =========== Submit Form ===========

        confirmForm && confirmForm.addEventListener('click', () => {
            const formData = new FormData(rejectForm);

            Swal.fire({
                title: 'ยืนยันการปฏิเศษ',
                // text: `ผ้เข้าร่วม ${formData.get('name') ?? "-"}`,
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

</html>