<?php

namespace FinalProject\View\Event;

require_once('components/map/map.php');
require_once('utils/useRegister.php');
require_once('components/texteditor/texteditor.php');

use FinalProject\Components\Map;
use FinalProject\Components\TextEditor;
use FinalProject\Utils\Register;

$map = new Map();
$map->setDefaultLocation($lat, $lon);

$textEditor = new TextEditor();
$textEditor->updatetextarea(description: $eventObj['description'], isEdit: false);

$textEditorDescription = new TextEditor();
$textEditorDescription->updatetextarea(description: $eventObj['description'], isEdit: false);

// ======================== Start Date ================================

$startDates = json_decode($eventObj['start'], true) ?? [];
$endDates = json_decode($eventObj['end'], true) ?? [];

$formattedDates = array_map(function ($date) {
    return date("l, j F Y", strtotime($date));
}, $startDates);

$maxDateDisplay = count($startDates);
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
                        $textEditor->render();
                        ?>
                    </div>

                    <!-- Map Link -->
                    <button type="button" onclick="scrollToView();" class="mt-8 lg:mt-14 flex justify-start items-center gap-2 w-auto lg:w-[150px] h-7">
                        <img width="19.3px" height="20px" src="public/icons/pin.svg" alt="Map pin" />
                        <div class="font-kanit text-base lg:text-[18px] min-w-[120px] whitespace-nowrap text-white text-opacity-100 leading-none font-normal">
                            ดูแผนที่
                        </div>
                    </button>
                </div>

                <!-- Right Section -->
                <div class="flex w-full lg:w-fit h-full items-end z-10">
                    <div class="flex flex-col justify-start items-start gap-8 p-4 lg:p-8 rounded-2xl w-full lg:w-[385px] h-fit max-h-1/2 shadow-md bg-white">
                        <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-[325px] h-fit">
                            <div class="font-kanit text-lg lg:text-xl min-w-full lg:min-w-[325px] whitespace-nowrap text-neutral-800 text-opacity-100 leading-none font-normal">
                                เวลาจัดงาน
                            </div>
                            <div class="flex flex-col font-kanit text-base w-full h-full gap-2 whitespace-nowrap text-gray-500 text-opacity-100 leading-none font-normal">
                                <?php foreach (array_slice($formattedDates, 0, $maxDateDisplay) as $date): ?>
                                    <span><?= htmlspecialchars($date) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <!-- <div class="font-kanit text-base lg:text-[18px] min-w-full lg:min-w-[325px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                                <span>
                                    อาทิตย์ที่ 12 ม.ค. 2025 : 9.00 PM
                                </span>
                            </div> -->
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col justify-end gap-2.5 h-full w-full">
                            <form action="../?action=request&on=event&form=register" method="post" class="flex flex-col gap-2.5">
                                <?php if (!empty($_SESSION['user']) && isset($_SESSION['user']['userId'])): ?>
                                    <input type="hidden" name="eventId" value="<?= htmlspecialchars($eventObj['eventId']) ?>">
                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($_SESSION['user']['userId']) ?>">

                                    <?php
                                    $buttons = [
                                        'accept' => [
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

                                    // print_r($regObj);

                                    $status = $regObj['data']['status'] ?? 'default';
                                    $status = in_array($status, Register::REGISTER_STATUS) ? $status : 'default';

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
                    <div class="font-kanit text-xl text-white font-semibold">
                        คำอธิบาย
                    </div>
                    <?php
                    $textEditorDescription->render();
                    ?>
                </div>

                <!-- Event Location -->
                <div class="flex flex-col justify-start items-start gap-2.5 w-full h-full lg:w-1/2 relative">
                    <div class="font-kanit text-xl text-white font-normal">
                        สถานที่จัดงาน
                    </div>
                    <div class="flex flex-col w-full h-full relative">
                        <?php $map->render(); ?>

                        <!-- Copy Button -->
                        <button
                            class="absolute top-0 right-4 flex justify-start items-center gap-3 px-4 py-2 rounded-b-md bg-neutral-400/50 hover:bg-black transition-colors duration-300 ease-in-out z-10 group">
                            <span class="font-kanit text-base underline text-black group-hover:text-white font-normal transition-colors duration-300 ease-in-out">คัดลอก</span>
                            <div class="flex flex-row justify-center items-center gap-2.5 rounded-full w-6 h-6 bg-orange-50 group-hover:bg-white overflow-hidden transition-colors duration-300 ease-in-out">
                                <img width="13.5px" height="13.5px" src="public/icons/copy.svg" alt="copy" class="group-hover:invert" />
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-start items-start gap-2.5 w-full h-fit lg:w-1/2 relative">
                <div class="font-kanit text-xl text-white font-normal">
                    เวลาจัดงาน
                </div>
                <div class="flex flex-col font-kanit text-base w-full h-full min-h-fit gap-2 whitespace-nowrap text-white text-opacity-100 leading-none font-normal">
                    <?php foreach (array_slice($formattedDates, 0, $maxDateDisplay) as $date): ?>
                        <span><?= htmlspecialchars($date) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const status = <?= $_GET['status'] ?>

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

            default:
                break;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const registerButton = document.getElementById("registerEvent");
            const rejectButton = document.getElementById("rejectEvent");
            const form = document.querySelector("form");

            if (registerButton) {
                registerButton.addEventListener("click", function() {
                    form.submit();
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