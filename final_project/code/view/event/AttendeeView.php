<?php

namespace FinalProject\View\Event;

require_once('utils/useRegister.php');
require_once('components/texteditor/texteditor.php');

use FinalProject\Components\TextEditor;
use FinalProject\Utils\Register;

$detail = new TextEditor();
$detail->updatetextarea(description: $eventObj['description'], isEdit: false);

$detailDescription = new TextEditor();
$detailDescription->updatetextarea(description: $eventObj['description'], isEdit: false);

$location = new TextEditor();
$location->updatetextarea(description: $eventObj['location'], isEdit: false);

// print_r($eventObj);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Attendance</title>
</head>

<body class="bg-primary">
    <div
        class="flex flex-col justify-center items-center gap-12 py-[200px] pr-10 pl-10 w-full h-fit">
        <div class="flex flex-col justify-start items-center gap-6 w-full shadow-sm p-4">
            <div
                class="relative flex flex-col lg:flex-row justify-between items-end lg:items-center py-6 px-6 lg:px-8 gap-6 lg:gap-10 w-full max-w-[1650px] h-auto lg:h-[700px] rounded-3xl bg-cover bg-center overflow-hidden"
                style="background-image: url('public/images/uploads/<?= $eventObj['cover'] ?>');">
                <!-- Left Section -->
                <div class="flex flex-col justify-start items-start h-auto lg:h-[620px] w-full lg:w-auto z-10">
                    <!-- Back Button -->
                    <a href="../" class="flex flex-row justify-center items-center gap-2 py-2 px-4 rounded-lg h-11 shadow-sm bg-orange-50 min-w-[119px]">
                        <img width="16px" height="16px" src="public/icons/drop.svg" alt="Back" class="transform rotate-90" />
                        <span class="font-kanit text-lg min-w-[72px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-light">
                            ย้อนกลับ
                        </span>
                    </a>

                    <!-- Content -->
                    <div class="flex flex-col justify-start items-start gap-2.5 mt-8 lg:mt-[91px] h-full max-h-[400px] w-full lg:w-[440px]">
                        <div class="font-kanit text-2xl lg:text-3xl min-w-full lg:min-w-[440px] whitespace-nowrap text-white text-opacity-100 leading-none font-medium">
                            <?= $eventObj['title'] ?>
                        </div>
                        <!-- <div class="font-kanit text-sm lg:text-base w-full lg:w-[440px] text-white text-opacity-100 leading-none font-normal">
                            "Eat with Me: How to Eat for Health"<br />มาร่วมงาน "Eat with Me" กับเรา! 🌿✨<br />งานที่จะพาคุณเรียนรู้เกี่ยวกับการรับประทานอาหารอย่างถูกต้อง เพื่อสุขภาพที่ดีและสมดุล พบกับแนวทางการเลือกอาหารที่มีประโยชน์ เคล็ดลับการกินเพื่อสุขภาพ และไอเดียเมนูอร่อยที่ดีต่อร่างกาย<br /><br />📅 วันและเวลา: 12 มกราคาม 2568📍 สถานที่: Coworking space ท่าขอนยาง<br /><br />ร่วมสัมผัสประสบการณ์การกินอย่างมีสติ และค้นพบวิธีดูแลสุขภาพผ่านอาหารที่อร่อยและมีคุณค่าทางโภชนาการ! 🥗🍎
                        </div> -->
                        <?php
                        $detail->render();
                        ?>
                    </div>

                    <!-- Map Link -->
                    <!-- <button type="button" onclick="scrollToView();" class="mt-8 lg:mt-14 flex justify-start items-center gap-2 w-auto lg:w-[150px] h-7">
                        <img width="19.3px" height="20px" src="public/icons/pin.svg" alt="Map pin" />
                        <div class="font-kanit text-base lg:text-[18px] min-w-[120px] whitespace-nowrap text-white text-opacity-100 leading-none font-normal">
                            ดูแผนที่
                        </div>
                    </button> -->
                </div>

                <!-- Right Section -->
                <div class="flex w-full lg:w-fit h-full items-end z-10">
                    <div class="flex flex-col justify-start items-start gap-8 p-4 lg:p-8 rounded-2xl w-full lg:w-[385px] h-fit max-h-1/2 shadow-md bg-white">
                        <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-[325px] h-fit">
                            <div class="font-kanit text-lg lg:text-xl min-w-full lg:min-w-[325px] whitespace-nowrap text-neutral-800 text-opacity-100 leading-none font-normal">
                                เวลาจัดงาน
                            </div>
                            <div class="flex flex-col font-kanit text-base w-full h-full gap-2 whitespace-nowrap text-gray-500 text-opacity-100 leading-none font-normal">
                                <span>เริ่มงาน: <?= $eventObj['start'] ?></span>
                                <span>สิ้นสุด: <?= $eventObj['end'] ?></span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col justify-end gap-2.5 h-full w-full">
                            <form
                                action="../?action=request&on=event&form=register"
                                method="post"
                                class="flex flex-col gap-2.5"
                                id="regForm">
                                <?php if (($_GET['joined']) >= $eventObj['maximum']): ?>
                                    <button type="button" class="btn-gray">เต็ม</button>
                                <?php elseif (!empty($_SESSION['user']) && isset($_SESSION['user']['userId'])): ?>
                                    <input type="hidden" name="eventId" value="<?= htmlspecialchars($eventObj['eventId']) ?>">
                                    <input type="hidden" name="joined" value="<?= (isset($_GET['joined']) ? $_GET['joined'] : 0) ?>">
                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($_SESSION['user']['userId']) ?>">

                                    <?php
                                    $buttons = [
                                        'accepted' => [
                                            ['class' => 'btn-primary w-full', 'label' => 'แสดงบัตร', 'id' => 'acceptEvent'],
                                            ['class' => 'btn-primary-outline w-full', 'label' => 'ดาวน์โหลดบัตร', 'id' => 'downloadTicket']
                                        ],
                                        'pending' => [
                                            ['class' => 'btn-warring w-full', 'label' => 'รออนุมัติ', 'id' => 'pendingEvent']
                                        ],
                                        'reject' => [
                                            ['class' => 'btn-danger w-full', 'label' => 'ดูเหตุผล', 'id' => 'rejectEvent']
                                        ],
                                        'default' => [
                                            ['class' => 'btn-primary w-full', 'label' => 'เข้าร่วม', 'id' => 'registerEvent']
                                        ]
                                    ];

                                    $status = (isset($regObj['data']['status']) ? trim($regObj['data']['status']) : null) ?? 'default';
                                    $status = in_array($status, Register::REGISTER_STATUS) ? $status : 'default';

                                    // print_r($status);

                                    foreach ($buttons[$status] as $button) {
                                        echo "<button type='button' class='{$button['class']}' id='{$button['id']}'><span>{$button['label']}</span></button>";
                                    }

                                    unset($regObj['data']);
                                    ?>

                                <?php else : ?>
                                    <a href="../?action=login" class="btn-gray">เข้าสู่ระบบก่อน</a>

                                <?php endif ?>
                            </form>
                            <!-- <a href="#" class="btn-primary-outline w-full group no-underline">
                                <span class="group-hover:text-white">สนใจ</span>
                            </a> -->
                        </div>
                    </div>
                </div>

                <!-- Cover -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm z-1"></div>
            </div>
        </div>

        <!-- Detail -->
        <div class="flex flex-col justify-start items-start gap-12 lg:gap-24 w-full max-w-[1200px] h-fit p-4" id="detail-section">
            <div class="flex w-full max-w-content h-full overflow-auto gap-8" id="imageContainer">
                <?php foreach (json_decode($eventObj['morePics'], true) as $item) : ?>
                    <div class="flex bg-dark-primary h-[180px] min-w-[320px] bg-cover bg-center rounded-lg"
                        style="background-image: url('public/images/uploads/<?= htmlspecialchars($item) ?>');">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex flex-col lg:flex-row justify-between items-start gap-6 w-full *:max-w-none *:lg:max-w-[512px]">
                <!-- Description -->
                <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-1/2">
                    <h1 class="text-white font-semibold">คำอธิบาย</h1>

                    <?php
                    $detailDescription->render();
                    ?>
                </div>

                <!-- Event Location -->
                <div class="flex flex-col justify-start items-start gap-2.5 w-full h-full lg:w-1/2 relative">
                    <h1 class="text-white font-semibold">สถานที่จัดงาน</h1>

                    <?php
                    $location->render();
                    ?>
                </div>
            </div>

            <div class="flex flex-col justify-start items-start gap-5 w-full h-fit lg:w-1/2 relative">
                <h1 class="text-white font-semibold">เวลาจัดงาน</h1>
                <div class="flex flex-col font-kanit text-base w-full h-full gap-2 whitespace-nowrap text-light-green text-opacity-100 leading-none font-normal">
                    <span>เริ่มงาน: <?= $eventObj['start'] ?></span>
                    <span>สิ้นสุด: <?= $eventObj['end'] ?></span>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const status = <?= $_GET['status'] ?>;

            const url = new URL(window.location.href);
            url.searchParams.delete("status");
            window.history.replaceState({}, document.title, url.toString());

            switch (status) {
                case 409:
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด",
                        text: "คุณเป็นผู้สร้างกิจกรรม, คุณมีสิทธิ์เข้าร่วมอยู่แล้ว",
                        icon: "error",
                        timerProgressBar: true,
                        timer: 3500,
                        confirmButtonText: "ปิด"
                    });
                    break;
                case 403:
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด",
                        text: "ดูเหมือนว่าคุณยังไม่ได้ยืนยันตัวตน",
                        icon: "warning",
                        showDenyButton: true,
                        confirmButtonText: "ยืนยันตอนนี้",
                        denyButtonText: "ยังก่อน"
                    }).then((res) => {
                        if (res.isConfirmed) {
                            window.location.href = "../?action=profile&isEdit=true";

                        }

                    });
                    break;

                default:
                    break;
            }

        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const registerButton = document.getElementById("registerEvent");
            const rejectButton = document.getElementById("rejectEvent");
            const form = document.getElementById('regForm');

            if (registerButton) {
                registerButton.addEventListener("click", function() {
                    // console.log("Clicked work!")

                    Swal.fire({
                        title: "ยืนยันการเข้าร่วม",
                        text: "คุณต้องการเข้าร่วมกิจกรรมนี้หรือไม่?",
                        icon: "warning",
                        showDenyButton: true,
                        confirmButtonText: "เข้าร่วมทันที",
                        denyButtonText: "ไม่่ใช่ตอนนี้"
                    }).then(async (res) => {
                        if (res.isConfirmed) {
                            console.log("Clicked work!")

                            const response = await fetch('../?action=request&on=user&form=profileVerify', {
                                method: 'post',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    userId: '<?= $_SESSION['user']['userId'] ?>'
                                })
                            }).then((res) => {
                                const status = res?.status ?? 404;

                                form.submit();

                            });

                        }

                    });
                });
            }

            if (rejectButton) {
                rejectButton.addEventListener("click", function() {
                    Swal.fire({
                        title: "การเข้าร่วมถูกปฏิเสธ",
                        text: "เหตุผล: <?= htmlspecialchars($regObj['reject_reason'] ?? 'ไม่ระบุ, ติดต่อผู้สร้างกิจกรรม') ?>",
                        icon: "error",
                        confirmButtonText: "ปิด"
                    });
                });
            }
        });

        function scrollToView() {
            const mapSection = document.getElementById('detail-section');
            const navbarHeight = document.getElementById('navbar').offsetHeight;
            window.scrollTo({
                top: mapSection.offsetTop - navbarHeight,
                behavior: 'smooth'
            });
        }

        const container = document.getElementById("imageContainer");

        container.addEventListener("wheel", function(event) {
            event.preventDefault();
            container.scrollLeft += event.deltaY;
        });
    </script>

</body>