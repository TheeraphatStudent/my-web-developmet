<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../components/navbar.php');

$navbar = new Navbar();

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
    <div class="lg:pt-[12rem] lg:pb-[8rem] pb-[4rem] pt-[8rem]">
        <div
            class="flex flex-col justify-end items-center w-[clamp(350px,85vw,1650px)] min-w-[400px] h-[clamp(300px,40vw,700px)] rounded-3xl bg-[url(/public/images/banner.jpg)] bg-center bg-cover overflow-hidden">
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
    <div class="flex w-screen h-screen max-w-content">
        <div class="w-full h-full bg-gray">
            Hello World
        </div>
    </div>
</body>

</html>