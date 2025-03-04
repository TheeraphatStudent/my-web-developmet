<?php

namespace FinalProject\View;

require_once(__DIR__ . '/../components/calendar/calendar.php');

use FinalProject\Components\SchedulerCalendar;

$calendar = new SchedulerCalendar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/style/main.css">

    <title>Profile</title>
</head>

<body class="bg-primary w-screen h-fit flex flex-col justify-start items-center pt-[120px] mb-[160px] px-5 lg:px-16 gap-16">
    <div class="inline-flex flex-col w-full h-fit max-w-content gap-10">
        <div class="flex w-full justify-between">
            <span class="text-2xl md:text-4xl font-semibold font-kanit text-white text-overflow">Profile</span>
            <button type="button" class="btn-secondary w-24 md:w-48 text-xl">Edit</button>
        </div>

        <div class="flex flex-col md:flex-row gap-10 bg-white/40 w-full h-28 min-h-fit rounded-xl p-8">
            <div class="overflow-hidden w-[150px] h-[150px] bg-black rounded-full border-[3px] border-black">
                <img class="w-full h-full object-cover" src="public/images/banner.jpg" alt="Profile" srcset="">
            </div>
            

            <div class="flex flex-col justify-around w-full max-w-[500px] gap-3 overflow-hidden">
                <span class="text-2xl md:text-4xl font-semibold font-kanit text-secondary/80 text-overflow">Theeraphat Chueanokkhum</span>
                <span class="font-kanit font-light text-lg md:text-2xl text-black text-overflow">AGU-TheeraphatCH00001</span>
            </div>
        </div>
    </div>

    <div class="inline-flex flex-col w-full h-fit max-w-content gap-10">
        <div class="flex w-full justify-between">
            <span class="text-2xl md:text-4xl font-semibold font-kanit text-white text-overflow">อีเวนท์เดือนนี้</span>
            <!-- <button type="button" class="btn-secondary w-24 md:w-48 text-xl">Edit</button> -->
        </div>

        <?php
        $calendar->render();
        ?>

    </div>
</body>

</html>