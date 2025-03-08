<?php

namespace FinalProject\View;

require_once(__DIR__ . '/../components/search.php');
require_once(__DIR__ . '/../components/calendar/calendar.php');

use FinalProject\Components\Search;
use FinalProject\Components\Filter;
use FinalProject\Components\SchedulerCalendar;

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

    <style>
        .text-container {
            position: relative;
        }

        .animated-text {
            font-size: 40px;
            font-weight: bold;
            display: inline-block;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            animation: float 3s ease-in-out infinite;
        }

        .animated-text span {
            display: inline-block;
            animation: colorChange 3s infinite;
        }

        .animated-text span:nth-child(1) {
            animation-delay: 0.1s;
        }

        .animated-text span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .animated-text span:nth-child(3) {
            animation-delay: 0.3s;
        }

        .animated-text span:nth-child(4) {
            animation-delay: 0.4s;
        }

        .animated-text span:nth-child(5) {
            animation-delay: 0.5s;
        }

        .animated-text span:nth-child(6) {
            animation-delay: 0.6s;
        }

        .animated-text span:nth-child(7) {
            animation-delay: 0.7s;
        }

        .animated-text span:nth-child(8) {
            animation-delay: 0.8s;
        }

        .animated-text span:nth-child(9) {
            animation-delay: 0.9s;
        }

        .animated-text span:nth-child(10) {
            animation-delay: 1.0s;
        }

        .animated-text span:nth-child(11) {
            animation-delay: 1.1s;
        }

        .animated-text span:nth-child(12) {
            animation-delay: 1.2s;
        }

        @keyframes colorChange {
            0% {
                color: #BCFFAB;
                transform: scale(1) rotate(0deg);
            }

            25% {
                color: #ABCDFF;
                transform: scale(1.1) rotate(5deg);
            }

            50% {
                color: #FBF8EE;
                transform: scale(1) rotate(0deg);
            }

            75% {
                color: #ABCDFF;
                transform: scale(1.1) rotate(-5deg);
            }

            100% {
                color: #BCFFAB;
                transform: scale(1) rotate(0deg);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .glow {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle, rgba(188, 255, 171, 0.3) 0%, rgba(0, 83, 186, 0.1) 50%, rgba(26, 26, 46, 0) 70%);
            filter: blur(20px);
            z-index: -1;
            animation: pulse 4s infinite;
        }
    </style>
</head>

<body class="flex flex-col justify-center items-center bg-primary relative gap-12">
    <!-- Cover Image -->
    <div class="relative lg:pt-[12rem] lg:pb-[8rem] pb-[4rem] pt-[8rem]">
        <div
            class="flex flex-col justify-end items-center w-[clamp(350px,85vw,1650px)] min-w-[400px] h-[clamp(300px,40vw,700px)] rounded-3xl bg-[url(/public/images/banner.jpg)] bg-center bg-cover overflow-hidden">
            <!-- Search -->
            <div class="absolute lg:bottom-[3.5rem] w-fit">
                <?php
                $search->render();
                ?>
            </div>

            <!-- Text -->
            <div
                class="flex flex-row justify-center items-center gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 rounded-3xl h-60 bg-gradient-to-b from-[rgba(251,248,238,0)] from-0% to-[rgba(34,110,106,1)] to-100% min-w-[1650px]">
                <div
                    class="font-kanit lg:text-4xl text-2xl w-fit whitespace-nowrap text-white text-opacity-100 leading-none text-dark/primary">
                    Create events, invite, and connect easily!
                </div>
            </div>

        </div>
    </div>

    <!-- Landing Content -->
    <div class="flex flex-col items-center w-full h-full min-h-fit gap-5 *:w-full *:h-full my-8">
        <!-- Filter -->
        <div class="w-full max-w-content h-fit max-h-fit mx-10 px-5 lg:px-16">
            <?php
            $filter->render();
            ?>
        </div>

        <!-- Content -->
        <?php if (count([...$allEvents]) > 0) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full max-w-content h-full min-h-fit mx-10 px-5 lg:px-16">
                <?php foreach ($allEvents as $item) :
                    // $dataUrl = "data:image/png;base64," . base64_encode(file_get_contents($item['cover']));
                    // print_r($dataUrl);
                ?>
                    <div class="flex flex-col justify-between items-center p-4 gap-4 rounded-lg w-full h-[420px] shadow-md bg-white hover:scale-105 hover:cursor-pointer">
                        <div
                            class="flex flex-col justify-between items-center bg-center bg-cover gap-[150px] rounded w-full h-60 overflow-hidden bg-dark-primary/50 border-dashed border-gray-400 border-2"
                            style="background-image: url(public/images/uploads/<?= $item['cover'] ?>);">
                            <!-- Tag -->
                            <div class="flex flex-row justify-start items-start gap-2.5 p-2.5 pb-3.5 w-full h-fit bg-gradient-to-b from-dark-primary/50 via-dark-primary/25 to-transparent">
                                <?php
                                $tags = [
                                    "online" => ["text" => "ONLINE", "background" => "bg-light-secondary", "color" => "text-secondary"],
                                    "onsite" => ["text" => "ONSITE", "background" => "bg-light-green", "color" => "text-primary"],
                                    "paid" => ["text" => "PAID", "background" => "bg-light-orange", "color" => "text-orange"],
                                    "free" => ["text" => "FREE", "background" => "bg-light-yellow", "color" => "text-yellow"]
                                ];

                                $selectedTags = [];

                                if ($item['type'] === 'online' || $item['type'] === 'any') {
                                    $selectedTags[] = "online";
                                }

                                if ($item['type'] === 'onsite' || $item['type'] === 'any') {
                                    $selectedTags[] = "onsite";
                                }

                                if ($item['venue'] > 0) {
                                    $selectedTags[] = "paid";
                                } else {
                                    $selectedTags[] = "free";
                                }

                                ?>
                                <?php foreach ($selectedTags as $tag): ?>
                                    <div class='flex justify-center items-center rounded w-16 h-8 shadow-sm <?= $tags[$tag]['background'] ?>'>
                                        <span class='font-kanit text-sm text-center whitespace-nowrap text-opacity-100 leading-none font-normal <?= $tags[$tag]['color'] ?>'>
                                            <?= $tags[$tag]['text'] ?>
                                        </span>
                                    </div>
                                <?php endforeach ?>
                            </div>

                            <!-- Star -->
                            <!-- <div class="flex flex-row justify-end items-center gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 w-full h-11">
                                    <div class="flex flex-row justify-center items-center gap-2.5 rounded-[50px] h-7 border-white border-t border-b border-l border-r border-dashed border overflow-hidden">
                                        <img src="/assets/ImageAsset10.png" alt="Image Asset 10" width="20px" height="20px" />
                                    </div>
                                </div> -->
                        </div>

                        <div class="flex flex-col justify-start items-start gap-3 h-24 w-full">
                            <div class="flex flex-col justify-start items-start h-fit py-2 w-full gap-2">
                                <div class="flex flex-row justify-between items-center gap-2.5 w-full h-7">
                                    <div class="font-kanit text-xl whitespace-nowrap text-black leading-none font-normal">
                                        <?= htmlspecialchars_decode($item['title'] ?? "-") ?>
                                    </div>
                                    <div class="font-kanit text-lg text-right whitespace-nowrap text-black leading-none font-normal">
                                        <?= htmlspecialchars_decode($item['maximum'] ?? "-") ?>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 font-kanit text-sm w-full whitespace-nowrap text-primary leading-none font-normal">
                                    <span>เริ่มงาน: <?= $item['start'] ?></span>
                                    <span>สิ้นสุด: <?= $item['end'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center gap-2.5 w-full h-9">
                            <a href="../?action=event.attendee&id=<?= $item['eventId'] ?>" class="btn-primary max-h-10 w-full max-w-[80%]">
                                <span class="font-kanit text-base text-white">
                                    ดูกิจกรรม
                                </span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="text-container flex justify-center items-center min-h-[450px] drop-shadow-2xl">
                <div class="animated-text text-white gap-0.5">

                    <?php
                    $text = "ไม่พบกิจกรรม";
                    $textArray = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

                    foreach ($textArray as $key => $value) {
                        echo "<span> $value </span>";
                    }
                    ?>
                </div>
            </div>

        <?php endif ?>

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