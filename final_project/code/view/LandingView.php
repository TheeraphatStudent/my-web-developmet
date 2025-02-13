<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../components/navbar.php');
require_once(__DIR__ . '/../components/calendar/calendar.php');

$navbar = new Navbar();
$calendar = new SchedulerCalendar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../public/style/main.css">
</head>

<body class="flex flex-col justify-center items-center bg-primary relative">
    <?php
    $navbar->render();
    ?>

    <!-- Cover Image -->
    <div class="relative lg:pt-[12rem] lg:pb-[8rem] pb-[4rem] pt-[8rem]">
        <div
            class="flex flex-col justify-end items-center w-[clamp(350px,85vw,1650px)] min-w-[400px] h-[clamp(300px,40vw,700px)] rounded-3xl bg-[url(/public/images/banner.jpg)] bg-center bg-cover overflow-hidden">
            <!-- Search -->
            <div
                class="absolute bottom-[3.5rem] bg-secondary flex justify-between items-center pr-[70px] pl-[70px] gap-10 rounded-[20px] w-[1200px] h-36 shadow-lg bg-blue-900">
                <div class="flex flex-row justify-start items-center gap-10 w-[950px]">
                    <div class="flex flex-col justify-start items-start gap-2.5 h-[70px]">
                        <div
                            class="font-kanit text-base min-w-[290px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                            กำลังมองหา
                        </div>
                        <div
                            class="flex justify-between items-center pr-2.5 pl-2.5 gap-48 rounded border-orange-50 border-t border-b border-l border-r border-solid border w-72 h-9 bg-orange-50">
                            <div
                                class="font-kanit text-xs min-w-[57px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                                เลือกอีเวทน์
                            </div>
                            <div class="flex flex-col justify-center items-center w-6 h-6">
                                <img
                                    width="14px"
                                    height="8px"
                                    src="/assets/SvgAsset4.svg"
                                    alt="Svg Asset 4" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-start items-start gap-2.5 h-[70px]">
                        <div
                            class="font-kanit text-base min-w-[290px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                            สถาณที่
                        </div>
                        <div
                            class="flex justify-between items-center pr-2.5 pl-2.5 gap-[152px] rounded w-72 h-9 bg-orange-50">
                            <div
                                class="font-kanit text-xs min-w-[98px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                                เลือกสถาณที่จัดงาน
                            </div>
                            <div
                                class="flex flex-col justify-center items-center rounded-[80px] h-5 overflow-hidden">
                                <img
                                    width="20px"
                                    height="18.5px"
                                    src="/assets/SvgAsset3.svg"
                                    alt="Svg Asset 3" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-start items-start gap-2.5 h-[70px]">
                        <div
                            class="font-kanit text-base min-w-[290px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                            ช่วงเวลา
                        </div>
                        <div
                            class="flex justify-between items-center pr-2.5 pl-2.5 gap-44 rounded border-orange-50 border-t border-b border-l border-r border-solid border w-72 h-9 bg-orange-50">
                            <div
                                class="font-kanit text-xs min-w-[67px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                                เลือกช่วงเวลา
                            </div>
                            <img
                                width="24px"
                                height="24px"
                                src="/assets/SvgAsset2.svg"
                                alt="Svg Asset 2" />
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-row justify-center items-center gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 rounded w-[70px] h-[70px] bg-neutral-800">
                    <div
                        class="flex justify-center items-center rounded-[80px] w-7 h-7 overflow-hidden">
                        <img
                            width="24px"
                            height="24px"
                            src="/assets/SvgAsset1.svg"
                            alt="Svg Asset 1" />
                    </div>
                </div>
            </div>


            <!-- Text -->
            <div
                class="flex flex-row justify-center items-center gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 rounded-3xl h-60 bg-gradient-to-b from-[rgba(251,248,238,0)] from-0% to-[rgba(34,110,106,1)] to-100% min-w-[1650px]">
                <div
                    class="font-kanit lg:text-4xl text-2xl w-fit whitespace-nowrap text-teal-700 text-opacity-100 leading-none text-dark/primary">
                    Create events, invite, and connect easily!
                </div>
            </div>

        </div>
    </div>

    <!-- Landing Content -->
    <div class="flex flex-col w-screen h-screen max-w-content gap-5 *:w-full *:h-full">
        <div class="">
            <?php 
            $calendar->render();
            ?>
        </div>
        <div class=">
            Hello World
        </div>
    </div>
</body>

</html>