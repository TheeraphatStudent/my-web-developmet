<?php

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
        class="flex flex-col justify-center items-center gap-12 pt-[200px] pr-10 pb-[200px] pl-10 w-full h-h-full">
        <div class="flex flex-col justify-start items-center gap-6 w-full shadow-sm p-4">
            <div class="relative flex flex-col lg:flex-row justify-between items-end lg:items-center py-6 px-6 lg:px-8 gap-6 lg:gap-10 w-full max-w-[1650px] h-auto lg:h-[700px] rounded-3xl bg-[url(https://picsum.photos/id/237/1920/1080)] bg-cover bg-center overflow-hidden">
                <!-- Left Section -->
                <div class="flex flex-col justify-start items-start h-auto lg:h-[623px] w-full lg:w-auto z-10">
                    <!-- Back Button -->
                    <div class="flex flex-row justify-center items-center gap-2 py-2 px-4 rounded-lg h-11 shadow-sm bg-orange-50 min-w-[119px]">
                        <img width="16px" height="16px" src="public/icons/drop.svg" alt="Back" class="transform rotate-90" />
                        <div class="font-kanit text-lg min-w-[72px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-light">
                            ย้อนกลับ
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col justify-start items-start gap-2.5 mt-8 lg:mt-[91px] h-auto lg:h-[400px] w-full lg:w-[440px]">
                        <div class="font-kanit text-2xl lg:text-3xl min-w-full lg:min-w-[440px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-medium">
                            Eat with me!
                        </div>
                        <div class="font-kanit text-sm lg:text-base w-full lg:w-[440px] text-orange-50 text-opacity-100 leading-none font-normal">
                            "Eat with Me: How to Eat for Health"<br />มาร่วมงาน "Eat with Me" กับเรา! 🌿✨<br />งานที่จะพาคุณเรียนรู้เกี่ยวกับการรับประทานอาหารอย่างถูกต้อง เพื่อสุขภาพที่ดีและสมดุล พบกับแนวทางการเลือกอาหารที่มีประโยชน์ เคล็ดลับการกินเพื่อสุขภาพ และไอเดียเมนูอร่อยที่ดีต่อร่างกาย<br /><br />📅 วันและเวลา: 12 มกราคาม 2568📍 สถานที่: Coworking space ท่าขอนยาง<br /><br />ร่วมสัมผัสประสบการณ์การกินอย่างมีสติ และค้นพบวิธีดูแลสุขภาพผ่านอาหารที่อร่อยและมีคุณค่าทางโภชนาการ! 🥗🍎
                        </div>
                    </div>

                    <!-- Map Link -->
                    <a href="#" class="mt-8 lg:mt-14 flex justify-start items-center gap-2 w-auto lg:w-[150px] h-7">
                        <img width="19.3px" height="20px" src="public/icons/pin.svg" alt="Map pin" />
                        <div class="font-kanit text-base lg:text-[18px] min-w-[120px] whitespace-nowrap text-white text-opacity-100 leading-none font-normal">
                            ดูแผนที่
                        </div>
                    </a>
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
                            <div class="flex justify-center items-center rounded w-full lg:w-[325px] h-14 bg-teal-700 cursor-pointer">
                                <a href="#" class="font-kanit text-base min-w-[47px] whitespace-nowrap text-orange-50 text-opacity-100 text-center leading-none font-normal">
                                    เข้าร่วม
                                </a>
                            </div>
                            <div class="flex justify-center items-center rounded border-teal-700 border-2 w-full lg:w-[325px] h-14 cursor-pointer">
                                <a href="#" class="font-kanit text-base min-w-[34px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-normal">
                                    สนใจ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cover -->
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm z-1"></div>
            </div>
        </div>

        <!-- Detail -->
        <div class="flex flex-col justify-start items-start gap-12 h-[580px]">
            <div
                class="flex flex-row justify-between items-start gap-12 w-[1200px] h-[310px]">
                <div class="flex flex-col justify-start items-start gap-2.5 h-[310px]">
                    <div
                        class="font-kanit text-xl min-w-[550px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-semibold">
                        คำอธิบาย
                    </div>
                    <div
                        class="font-kanit text-base w-[550px] text-orange-50 text-opacity-100 leading-none font-normal">
                        &quot;Eat with Me: How to Eat for Health&quot;<br />มาร่วมงาน
                        &quot;Eat with Me&quot; กับเรา! 🌿✨<br />งานที่จะพาคุณเรียนรู้เกี่ยวกับการรับประทานอาหารอย่างถูกต้อง
                        เพื่อสุขภาพที่ดีและสมดุล พบกับแนวทางการเลือกอาหารที่มีประโยชน์
                        เคล็ดลับการกินเพื่อสุขภาพ และไอเดียเมนูอร่อยที่ดีต่อร่างกาย<br /><br />📅
                        วันและเวลา: 12 มกราคาม 2568📍 สถานที่: Coworking space ท่าขอนยาง<br /><br />ร่วมสัมผัสประสบการณ์การกินอย่างมีสติ
                        และค้นพบวิธีดูแลสุขภาพผ่านอาหารที่อร่อยและมีคุณค่าทางโภชนาการ! 🥗🍎
                    </div>
                </div>
                <div class="flex flex-col justify-start items-start gap-2.5 h-[310px]">
                    <div
                        class="font-kanit text-xl min-w-[550px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                        สถานที่จัดงาน
                    </div>
                    <div
                        class="flex justify-end items-end pb-4 pr-5 w-[550px] h-[260px] bg-ImageAsset1">
                        <div
                            class="flex flex-row justify-start items-center gap-2.5 pt-1 pr-2.5 pb-1 pl-2.5 rounded h-8 bg-neutral-400/50 min-w-[99px]">
                            <div
                                class="font-kanit text-base min-w-[49px] whitespace-nowrap underline text-neutral-800 text-opacity-100 leading-none font-normal">
                                <span class="underline">คัดลอก</span>
                            </div>
                            <div
                                class="flex flex-row justify-center items-center gap-2.5 rounded-[80px] h-5 bg-orange-50 overflow-hidden">
                                <img
                                    width="13.5px"
                                    height="13.5px"
                                    src="/assets/SvgAsset1.svg"
                                    alt="Svg Asset 1" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-row justify-between items-center gap-12 w-[1200px] h-[83px]">
                <div class="flex flex-col justify-start items-start gap-5 h-[83px]">
                    <div
                        class="font-kanit text-xl min-w-[550px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-semibold">
                        เวลา
                    </div>
                    <div
                        class="flex flex-row justify-start items-start gap-5 w-[550px] h-7">
                        <div
                            class="font-kanit text-base min-w-[64px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                            วันอาทิตย์
                        </div>
                        <div
                            class="font-kanit text-[18px] min-w-[66px] whitespace-nowrap text-amber-400 text-opacity-100 leading-none font-normal">
                            9.00 PM
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col justify-start items-start gap-2 w-[550px] h-[83px]">
                    <div
                        class="font-kanit text-xl min-w-[550px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-semibold">
                        มหาวิทยาลัยมหาสารคาม
                    </div>
                    <div
                        class="font-kanit text-base min-w-[480px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                        41 ตำบล ขามเรียง อำเภอกันทรวิชัย มหาสารคาม 44150
                    </div>
                </div>
            </div>
            <div
                class="flex flex-col justify-start items-end gap-2.5 w-[1200px] h-[87px]">
                <div class="flex flex-col justify-start items-start gap-5 h-20">
                    <div
                        class="font-kanit text-xl min-w-[550px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-semibold">
                        หัวข้อ
                    </div>
                    <div class="flex flex-row justify-start items-start gap-2.5 w-[550px]">
                        <div
                            class="flex justify-center items-center rounded w-[87px] h-8 bg-orange-50">
                            <div
                                class="font-kanit text-sm min-w-[67px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-normal">
                                EatWithMe
                            </div>
                        </div>
                        <div
                            class="flex justify-center items-center rounded w-[119px] h-8 bg-orange-50">
                            <div
                                class="font-kanit text-sm min-w-[99px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-normal">
                                กินอย่างมีสุขภาพ
                            </div>
                        </div>
                        <div
                            class="flex justify-center items-center rounded w-[136px] h-8 bg-orange-50">
                            <div
                                class="font-kanit text-sm min-w-[116px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-normal">
                                สุขภาพดีเริ่มที่อาหาร
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>