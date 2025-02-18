<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../components/navbar.php');
require_once(__DIR__ . '/../components/search.php');
require_once(__DIR__ . '/../components/calendar/calendar.php');

$navbar = new Navbar();

$search = new Search();
$filter = new Filter();

$calendar = new SchedulerCalendar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="public/images/logo.png">
    <link rel="stylesheet" href="public/style/main.css">
</head>

<body class="flex flex-col justify-center items-center bg-primary relative gap-12">
    <?php
    $navbar->render();
    ?>

    <!-- Cover Image -->
    <div class="relative lg:pt-[12rem] lg:pb-[8rem] pb-[4rem] pt-[8rem]">
        <div
            class="flex flex-col justify-end items-center w-[clamp(350px,85vw,1650px)] min-w-[400px] h-[clamp(300px,40vw,700px)] rounded-3xl bg-[url(/public/images/banner.jpg)] bg-center bg-cover overflow-hidden">
            <!-- Search -->
            <div class="absolute lg:bottom-[3.5rem]">
                <?php
                $search->render();
                ?>
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
    <div class="flex flex-col items-center w-full h-full min-h-fit gap-5 *:w-full *:h-full my-8">
        <!-- Filter -->
        <div class="w-full max-w-content h-fit max-h-fit mx-10">
            <?php
            $filter->render();
            ?>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full max-w-content h-full min-h-fit mx-10">
            <?php for ($i = 0; $i < 6; $i++) : ?>
                <div class="flex flex-col justify-between items-center p-5 gap-4 rounded-lg w-full h-[422px] shadow-md bg-orange-50">
                    <div class="flex flex-col justify-between items-center gap-[150px] rounded w-full h-60 bg-[url(https://picsum.photos/seed/picsum/1920/1080)] overflow-hidden">
                        <!-- Tag -->
                        <div class="flex flex-row justify-start items-start gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 w-full h-11">
                            <div class="flex justify-center items-center rounded w-11 h-6 shadow-sm bg-orange-50">
                                <div class="font-kanit text-[10px] min-w-[23px] whitespace-nowrap text-teal-700 text-opacity-100 text-center leading-none font-normal">
                                    FREE
                                </div>
                            </div>
                            <div class="flex justify-center items-center rounded w-[67px] h-6 shadow-sm bg-blue-300">
                                <div class="font-kanit text-[10px] text-center min-w-[47px] whitespace-nowrap text-blue-900 text-opacity-100 leading-none font-normal">
                                    ONLINE
                                </div>
                            </div>
                        </div>

                        <!-- Star -->
                        <div class="flex flex-row justify-end items-center gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 w-full h-11">
                            <div class="flex flex-row justify-center items-center gap-2.5 rounded-[50px] h-7 border-orange-50 border-t border-b border-l border-r border-dashed border overflow-hidden">
                                <img src="/assets/ImageAsset10.png" alt="Image Asset 10" width="20px" height="20px" />
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-start items-start gap-3 h-20 w-full">
                        <div class="flex flex-col justify-start items-start h-12 w-full">
                            <div class="flex flex-row justify-between items-center gap-2.5 w-full h-7">
                                <div class="font-kanit text-lg whitespace-nowrap text-neutral-800 text-opacity-100 leading-none font-normal">
                                    Eat with me!
                                </div>
                                <div class="font-kanit text-lg text-right whitespace-nowrap text-neutral-800 text-opacity-100 leading-none font-normal">
                                    80/-
                                </div>
                            </div>
                            <div class="font-kanit text-xs w-full whitespace-nowrap text-teal-700 text-opacity-100 leading-none font-normal">
                                Sunday, 12 January 2025&nbsp;
                            </div>
                        </div>
                        <div class="font-kanit text-xs w-full whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                            ทุกที่
                        </div>
                    </div>
                    <div class="flex flex-row justify-center items-center gap-2.5 w-full h-9">
                        <a href="../?action=attendee" class="btn-primary max-h-10 w-full max-w-[80%]">
                            <span class="font-kanit text-base text-white">
                                เข้าร่วม
                            </span>
                        </a>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Suggest -->
        <div class="flex w-full items-end min-h-[400px] max-h-[400px]">
            <div class="w-full h-[200px] bg-white">
                <div class="flex justify-end items-center"></div>

            </div>

        </div>

        <!-- Step -->

    </div>

    <!-- <footer class="w-full h-[500px] bg-white">
    </footer> -->
</body>

</html>