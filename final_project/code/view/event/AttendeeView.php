<?php

namespace FinalProject\View\Event;

require_once('components/map/map.php');

use FinalProject\Components\Map;

$map = new Map();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">
    <title>Eat With Me</title>
</head>

<body class="bg-primary">
    <div
        class="flex flex-col justify-center items-center gap-12 pt-[200px] pr-10 pb-[200px] pl-10 w-full h-full">
        <div class="flex flex-col justify-start items-center gap-6 w-full shadow-sm p-4">
            <div class="relative flex flex-col lg:flex-row justify-between items-end lg:items-center py-6 px-6 lg:px-8 gap-6 lg:gap-10 w-full max-w-[1650px] h-auto lg:h-[700px] rounded-3xl bg-[url(https://picsum.photos/1920/1080)] bg-cover bg-center overflow-hidden">
                <!-- Left Section -->
                <div class="flex flex-col justify-start items-start h-auto lg:h-[623px] w-full lg:w-auto z-10">
                    <!-- Back Button -->
                    <a href="../" class="flex flex-row justify-center items-center gap-2 py-2 px-4 rounded-lg h-11 shadow-sm bg-orange-50 min-w-[119px]">
                        <img width="16px" height="16px" src="public/icons/drop.svg" alt="Back" class="transform rotate-90" />
                        <span class="font-kanit text-lg min-w-[72px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-light">
                            ย้อนกลับ
                        </span>
                    </a>

                    <!-- Content -->
                    <div class="flex flex-col justify-start items-start gap-2.5 mt-8 lg:mt-[91px] h-auto lg:h-[400px] w-full lg:w-[440px]">
                        <div class="font-kanit text-2xl lg:text-3xl min-w-full lg:min-w-[440px] whitespace-nowrap text-white text-opacity-100 leading-none font-medium">
                            Eat with me!
                        </div>
                        <div class="font-kanit text-sm lg:text-base w-full lg:w-[440px] text-white text-opacity-100 leading-none font-normal">
                            "Eat with Me: How to Eat for Health"<br />มาร่วมงาน "Eat with Me" กับเรา! 🌿✨<br />งานที่จะพาคุณเรียนรู้เกี่ยวกับการรับประทานอาหารอย่างถูกต้อง เพื่อสุขภาพที่ดีและสมดุล พบกับแนวทางการเลือกอาหารที่มีประโยชน์ เคล็ดลับการกินเพื่อสุขภาพ และไอเดียเมนูอร่อยที่ดีต่อร่างกาย<br /><br />📅 วันและเวลา: 12 มกราคาม 2568📍 สถานที่: Coworking space ท่าขอนยาง<br /><br />ร่วมสัมผัสประสบการณ์การกินอย่างมีสติ และค้นพบวิธีดูแลสุขภาพผ่านอาหารที่อร่อยและมีคุณค่าทางโภชนาการ! 🥗🍎
                        </div>
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
                    <div class="flex flex-col justify-start items-start gap-8 p-4 lg:p-8 rounded-2xl w-full lg:w-[385px] h-auto lg:h-[284px] shadow-md bg-white">
                        <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-[325px] h-auto lg:h-[73px]">
                            <div class="font-kanit text-lg lg:text-xl min-w-full lg:min-w-[325px] whitespace-nowrap text-neutral-800 text-opacity-100 leading-none font-normal">
                                เวลาจัดงาน
                            </div>
                            <div class="font-kanit text-base lg:text-[18px] min-w-full lg:min-w-[325px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                                <span>
                                    อาทิตย์ที่ 12 ม.ค. 2025 : 9.00 PM
                                </span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col justify-center items-center gap-2.5 h-auto lg:h-[118px] w-full">
                            <a href="#" class="btn-primary w-full">
                                <span>เข้าร่วม</span>
                            </a>
                            <a href="#" class="btn-primary-outline w-full group no-underline">
                                <span class="group-hover:text-white">สนใจ</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cover -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm z-1"></div>
            </div>
        </div>

        <!-- Detail -->
        <div class="flex flex-col justify-start items-start gap-14 lg:gap-36 w-full max-w-[1200px] mx-auto p-4" id="detail-section">
            <div class="flex flex-col lg:flex-row justify-between items-start gap-6 w-full *:max-w-none *:lg:max-w-[512px]">
                <!-- Description -->
                <div class="flex flex-col justify-start items-start gap-2.5 w-full lg:w-1/2">
                    <div class="font-kanit text-xl text-white font-semibold">
                        คำอธิบาย
                    </div>
                    <div class="font-kanit text-base text-white font-normal">
                        "Eat with Me: How to Eat for Health" มาร่วมงาน "Eat with Me" กับเรา! 🌿✨ งานที่จะพาคุณเรียนรู้เกี่ยวกับการรับประทานอาหารอย่างถูกต้อง
                        เพื่อสุขภาพที่ดีและสมดุล พบกับแนวทางการเลือกอาหารที่มีประโยชน์
                        เคล็ดลับการกินเพื่อสุขภาพ และไอเดียเมนูอร่อยที่ดีต่อร่างกาย
                        📅 วันและเวลา: 12 มกราคาม 2568📍 สถานที่: Coworking space ท่าขอนยาง
                        ร่วมสัมผัสประสบการณ์การกินอย่างมีสติ และค้นพบวิธีดูแลสุขภาพผ่านอาหารที่อร่อยและมีคุณค่าทางโภชนาการ! 🥗🍎
                    </div>
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

            <!-- Second Row: Time and Location -->
            <div class="flex flex-col lg:flex-row justify-between items-start gap-6 w-full *:max-w-none *:lg:max-w-[512px]">
                <!-- Time -->
                <div class="flex flex-col justify-start items-start gap-2 w-full lg:w-1/2">
                    <div class="font-kanit text-xl text-white font-semibold">
                        เวลา
                    </div>
                    <div class="flex flex-row justify-start items-start gap-5">
                        <div class="font-kanit text-base text-white font-normal">
                            วันอาทิตย์
                        </div>
                        <div class="font-kanit text-[18px] text-amber-400 font-normal">
                            9.00 PM
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="flex flex-col justify-start items-start gap-2 w-full lg:w-1/2">
                    <div class="font-kanit text-xl text-white font-semibold">
                        มหาวิทยาลัยมหาสารคาม
                    </div>
                    <div class="font-kanit text-base text-white font-normal">
                        41 ตำบล ขามเรียง อำเภอกันทรวิชัย มหาสารคาม 44150
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="flex flex-col justify-start items-start lg:justify-end lg:items-end gap-2.5 w-full *:max-w-none *:lg:max-w-[512px]">
                <div class="flex flex-col justify-start items-start gap-2 w-full">
                    <span class="font-kanit text-xl text-white font-semibold">หัวข้อ</span>
                    <div class="flex flex-row flex-wrap justify-start items-start gap-2.5">
                        <div class="tags">
                            <span>EatWithMe</span>
                        </div>
                        <div class="tags">
                            <span>กินอย่างมีสุขภาพ</span>
                        </div>
                        <div class="tags">
                            <span>สุขภาพดีเริ่มที่อาหาร</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function scrollToView() {
            const mapSection = document.getElementById('detail-section');
            const navbarHeight = document.getElementById('navbar').offsetHeight;
            window.scrollTo({
                top: mapSection.offsetTop - navbarHeight,
                behavior: 'smooth'
            });
        }
    </script>

</body>

</html>