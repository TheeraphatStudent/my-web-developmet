<?php

namespace FinalProject\View;

require_once(__DIR__ . '/../components/search.php');
require_once(__DIR__ . '/../components/calendar/calendar.php');
require_once('utils/useTags.php');

use FinalProject\Components\Search;
use FinalProject\Components\Filter;
use FinalProject\Components\SchedulerCalendar;

$search = new Search();
$filter = new Filter();

$calendar = new SchedulerCalendar();

// print_r($allEvents);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/x-icon" href="public/images/logo.png">
    <link rel="stylesheet" href="public/style/main.css">
</head>

<body class="relative flex flex-col justify-center items-center bg-primary gap-12 overflow-x-hidden">
    <!-- Cover Image Container -->
    <div class="relative lg:pt-[12rem] lg:pb-[8rem] py-[8rem]">
        <div
            class="flex flex-col justify-end items-center w-[clamp(350px,85vw,1650px)] min-w-[400px] h-[clamp(300px,40vw,700px)] rounded-3xl bg-[url(/public/images/banner.jpg)] bg-center bg-cover overflow-hidden">

            <!-- Text -->
            <div
                class="flex flex-row justify-center items-center gap-2.5 pt-2.5 pr-2.5 pb-2.5 pl-2.5 rounded-3xl h-60 bg-gradient-to-b from-[rgba(251,248,238,0)] from-0% to-[rgba(34,110,106,1)] to-100% min-w-[1650px]">
                <div
                    class="font-kanit lg:text-4xl text-2xl w-fit whitespace-nowrap text-white text-opacity-100 leading-none text-dark/primary">
                    <span class="typing-animation max-w-fit">
                        Create events, invite, and connect easily!
                    </span>
                </div>
            </div>

            <!-- Search Bar Positioned at the Bottom -->
            <div class="absolute bottom-[30px] w-fit">
                <?php
                $search->render();
                ?>
            </div>

        </div>
    </div>


    <!-- Landing Content -->
    <div class="flex flex-col items-center w-full h-full min-h-fit gap-5 *:w-full *:h-full mt-8">
        <!-- Filter -->
        <div class="w-full max-w-content h-fit max-h-fit mx-10 px-5 lg:px-16">
            <?php
            $filter->render();
            ?>
        </div>

        <!-- Content -->
        <?php if ((!empty($allEvents))) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full max-w-content h-full min-h-fit mx-10 px-5 lg:px-16">
                <?php foreach ($allEvents as $item) :
                    // $dataUrl = "data:image/png;base64," . base64_encode(file_get_contents($item['cover']));
                    // print_r($item);
                ?>
                    <div class="flex flex-col justify-between items-center p-4 gap-4 rounded-lg w-full h-[420px] shadow-md bg-white hover:scale-[101%] hover:cursor-pointer">
                        <div
                            class="flex flex-col justify-between items-stretch bg-center bg-cover rounded w-full h-60 overflow-hidden bg-dark-primary/50 border-dashed border-gray-400 border-2"
                            style="background-image: url(public/images/uploads/<?= $item['cover'] ?>);">
                            <!-- Tag -->
                            <div class="flex flex-row justify-start items-start gap-2.5 p-2.5 pb-3.5 w-full h-fit bg-gradient-to-b from-dark-primary/50 via-dark-primary/25 to-transparent">
                                <?php
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

                            <!-- Organize Detail -->
                            <div class="flex flex-row justify-start items-center gap-2.5 px-2.5 py-2 pt-6 w-full h-fit bg-gradient-to-t from-dark-primary/75 via-dark-primary/25 to-transparent">
                                <div class="w-[32px] h-[32px] flex items-center justify-center rounded-full <?= (isset($_SESSION['user']['userId']) && $item['organizeId'] === $_SESSION['user']['userId']) ? 'bg-dark-secondary' : 'bg-primary' ?> text-white text-sm font-bold">
                                    <?= htmlspecialchars(strtoupper(substr(($item['organizeName'] ?? "-"), 0, 1))) ?>
                                </div>
                                <span class="text-white text-sm">
                                    <?= htmlspecialchars($item['organizeName'] ?? "-") ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col justify-start items-start gap-3 h-24 w-full">
                            <div class="flex flex-col justify-start items-start h-fit py-2 w-full gap-2">
                                <div class="flex flex-row justify-between items-center gap-2.5 w-full h-7">
                                    <div class="font-kanit text-xl whitespace-nowrap text-black leading-none font-normal">
                                        <?= htmlspecialchars_decode($item['title'] ?? "-") ?>
                                    </div>
                                    <div class="font-kanit text-lg text-right whitespace-nowrap text-black leading-none font-normal">
                                        <?= htmlspecialchars_decode($item['maximum'] === -1 ? "-" : $item['maximum']) ?>/<?= htmlspecialchars_decode($item['joined'] ?? "0") ?>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 font-kanit text-sm w-full whitespace-nowrap text-primary leading-none font-normal">
                                    <span>เริ่มงาน: <?= $item['start'] ?></span>
                                    <span>สิ้นสุด: <?= $item['end'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-center items-center gap-2.5 w-full h-10">
                            <a href="../?action=event.attendee&id=<?= $item['eventId'] ?>&joined=<?= $item['joined'] ?>" class="btn-primary max-h-10 w-full max-w-[80%]">
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
                        echo "<span class='text-6xl'> $value </span>";
                    }
                    ?>
                </div>
            </div>

        <?php endif ?>

        <!-- Suggest -->
        <div class="relative w-full mx-auto h-auto md:h-[300px] mb-16 flex flex-col md:flex-row items-center">
            <div class="relative top-12 z-10 flex justify-center items-center py-8 gap-4 px-6 md:pr-[10%] w-full h-auto bg-white shadow-md">
                <div class="w-full h-full max-h-[420px] flex flex-col justify-center md:flex-row items-center md:items-start gap-4">

                    <!-- Image -->
                    <img class="w-[min(90%,320px)] md:w-[35vw] max-w-[320px] h-auto object-contain" src="public/images/meet.svg" alt="meeting" />

                    <!-- Text + Button -->
                    <div class="flex flex-col justify-center items-center md:items-start gap-3 text-center h-full md:text-left self-center">
                        <div class="font-kanit text-2xl md:text-3xl text-teal-700 leading-tight font-normal">
                            สร้าง<span class="font-bold">&nbsp;</span>
                            <a href="../?action=event.create" class="font-bold" style="text-decoration: underline;">กิจกรรม</a>
                            <span class="font-bold">&nbsp;</span>ของคุณได้ทันที
                        </div>

                        <a href="../?action=event.create" class="mt-4 md:mt-0 flex justify-center items-center w-full md:w-[300px] h-[60px] rounded-lg shadow-md bg-sky-700 hover:bg-sky-800 transition">
                            <span class="font-kanit text-[18px] text-white font-normal">
                                สร้างเลย
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="flex flex-col justify-between items-center pt-10 lg:pt-[69px] gap-8 mb-16 lg:gap-12 w-full max-w-content px-4">
            <div class="font-kanit text-2xl lg:text-4xl text-center text-orange-50 leading-none font-bold">
                จะเข้าร่วม อีเวนท์ ทำได้ยังไง?
            </div>

            <div class="flex flex-col lg:flex-row justify-between items-center gap-8 w-full">
                <div class="flex flex-col md:justify-start justify-center items-start w-full lg:w-72 md:min-h-[280px] bg-white shadow-md">
                    <div class="w-full lg:w-72 h-3 bg-red"></div>
                    <div class="flex flex-col justify-start items-center gap-8 lg:gap-12 p-5 w-full lg:w-72">
                        <div class="flex flex-col justify-start items-center gap-2.5">
                            <img class="shadow-sm w-16 h-16 lg:w-20 lg:h-20"
                                src="public/icons/account.svg"
                                alt="create account" />
                            <div class="font-kanit text-lg lg:text-xl text-center text-neutral-800 leading-none font-medium">
                                สร้างบัญชีผู้ใช้
                            </div>
                        </div>
                        <div class="font-kanit text-base lg:text-lg text-center text-neutral-800 leading-relaxed lg:leading-none font-light">
                            เราจำเป็นต้องใช้ข้อมูลส่วนตัว<br />ของคุณ เพื่อให้ง่ายต่อ
                            การเข้าร่วมอีเวนท์
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:justify-start justify-center items-start w-full lg:w-72 md:min-h-[280px] bg-white shadow-md">
                    <div class="w-full lg:w-72 h-3 bg-yellow"></div>
                    <div class="flex flex-col justify-start items-center gap-8 lg:gap-12 p-5 w-full lg:w-72">
                        <div class="flex flex-col justify-start items-center gap-2.5">
                            <div class="flex justify-center items-center w-16 h-16 lg:w-20 lg:h-20 rounded-lg bg-amber-100">
                                <img class="w-12 h-12 lg:w-16 lg:h-16"
                                    src="public/icons/note.svg"
                                    alt="event" />
                            </div>
                            <div class="font-kanit text-lg lg:text-xl text-center text-neutral-800 leading-none font-medium">
                                ค้นหาอีเวนท์ที่สนใจ
                            </div>
                        </div>
                        <div class="font-kanit text-base lg:text-lg text-center text-neutral-800 leading-relaxed lg:leading-none font-light">
                            เพียงแค่คลิก "เข้าร่วม" คุณก็สามารถเข้าร่วมอีเวนท์<br />ได้ทันที
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:justify-start justify-center items-start w-full lg:w-72 md:min-h-[280px] bg-white shadow-md">
                    <div class="w-full lg:w-72 h-3 bg-green"></div>
                    <div class="flex flex-col justify-start items-center gap-8 lg:gap-12 p-5 w-full lg:w-72">
                        <div class="flex flex-col justify-start items-center gap-2.5">
                            <img class="w-16 h-16 lg:w-20 lg:h-20"
                                src="public/icons/community.svg"
                                alt="community" />
                            <div class="font-kanit text-lg lg:text-xl text-center text-neutral-800 leading-none font-medium">
                                เข้าร่วมได้ทันที
                            </div>
                        </div>
                        <div class="font-kanit text-base lg:text-lg text-center text-neutral-800 leading-relaxed lg:leading-none font-light">
                            เตรียมตัวให้พร้อมกับ อีเวนท์ที่กำลังจะมาถึง!
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block mt-16">
            <div class=" flex flex-col items-center justify-center gap-5 text-white">
                <img src="public/images/logo.png" alt="logo" width="128px" height="128px" class="invert" style="filter: brightness(0) invert(1);">
                <span>Create events, invite, and connect easily!</span>
            </div>

            <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 360" xmlns="http://www.w3.org/2000/svg" class="transition duration-350 ease-in-out delay-250">
                <style>
                    .path-0 {
                        animation: pathAnim-0 4s;
                        animation-timing-function: linear;
                        animation-iteration-count: infinite;
                    }

                    @keyframes pathAnim-0 {
                        0% {
                            d: path("M 0,400 L 0,75 C 52.542912182808564,69.16958757995027 105.08582436561713,63.33917515990055 140,62 C 174.91417563438287,60.66082484009945 192.19961472034004,63.812886940348086 232,60 C 271.80038527965996,56.187113059651914 334.11571675302247,45.40927707870713 381,54 C 427.88428324697753,62.59072292129287 459.3375182675701,90.5500047448234 486,98 C 512.6624817324299,105.4499952551766 534.5342101766972,92.39070394199928 580,87 C 625.4657898233028,81.60929605800072 694.525641025641,83.8871794871795 736,75 C 777.474358974359,66.1128205128205 791.3632257207388,46.06057810928278 827,53 C 862.6367742792612,59.93942189071722 920.0214560914043,93.8705080756894 966,105 C 1011.9785439085957,116.1294919243106 1046.5509499136442,104.45738958795954 1086,96 C 1125.4490500863558,87.54261041204046 1169.774744254019,82.29993357247243 1206,75 C 1242.225255745981,67.70006642752757 1270.3500730702801,58.342876122150734 1308,58 C 1345.6499269297199,57.657123877849266 1392.82496346486,66.32856193892464 1440,75 L 1440,400 L 0,400 Z");
                        }

                        25% {
                            d: path("M 0,400 L 0,75 C 27.8434151340887,84.44121163810283 55.6868302681774,93.88242327620567 98,87 C 140.3131697318226,80.11757672379433 197.09609406137906,56.911518533280194 241,46 C 284.90390593862094,35.088481466719806 315.9287934863064,36.47150259067357 351,44 C 386.0712065136936,51.52849740932643 425.1887319933952,65.20247110402552 464,79 C 502.8112680066048,92.79752889597448 541.3162785401129,106.7186129932244 582,109 C 622.6837214598871,111.2813870067756 665.5461538461537,101.9230769230769 708,100 C 750.4538461538463,98.0769230769231 792.4991060752719,103.58907931446792 839,99 C 885.5008939247281,94.41092068553208 936.4574218527587,79.72060581905143 981,74 C 1025.5425781472413,68.27939418094857 1063.6712065136935,71.52849740932642 1092,71 C 1120.3287934863065,70.47150259067358 1138.857752092467,66.1654045436429 1182,75 C 1225.142247907533,83.8345954563571 1292.8977851164382,105.80988441610202 1340,108 C 1387.1022148835618,110.19011558389798 1413.551107441781,92.59505779194899 1440,75 L 1440,400 L 0,400 Z");
                        }

                        50% {
                            d: path("M 0,400 L 0,75 C 43.5802881056767,68.25237715652224 87.1605762113534,61.50475431304447 123,60 C 158.8394237886466,58.49524568695553 186.93798326026308,62.233359904344354 229,62 C 271.0620167397369,61.766640095655646 327.0874907475943,57.56180606957808 370,50 C 412.9125092524057,42.43819393042192 442.7120537493595,31.51941581734328 480,39 C 517.2879462506405,46.48058418265672 562.0642942549679,72.3605306610488 598,74 C 633.9357057450321,75.6394693389512 661.0307692307691,53.03846153846155 702,53 C 742.9692307692309,52.96153846153845 797.8126288219554,75.48562318510504 837,76 C 876.1873711780446,76.51437681489496 899.7187154814095,55.01904572111827 941,50 C 982.2812845185905,44.98095427888173 1041.3125092524058,56.43819393042192 1092,69 C 1142.6874907475942,81.56180606957808 1185.0312475089677,95.2281785571941 1218,89 C 1250.9687524910323,82.7718214428059 1274.5625007117235,56.64909184080169 1310,51 C 1345.4374992882765,45.35090815919831 1392.7187496441384,60.175454079599156 1440,75 L 1440,400 L 0,400 Z");
                        }

                        75% {
                            d: path("M 0,400 L 0,75 C 31.519461367647892,93.36962648750213 63.038922735295785,111.73925297500428 104,111 C 144.96107726470422,110.26074702499572 195.36377042646473,90.41261458748504 241,87 C 286.6362295735353,83.58738541251496 327.5059955588453,96.61028867505551 368,89 C 408.4940044411547,81.38971132494449 448.61224733815413,53.14623071229289 488,57 C 527.3877526618459,60.85376928770711 566.0450150885384,96.80478847577294 608,97 C 649.9549849114616,97.19521152422706 695.2076923076922,61.63461538461539 737,56 C 778.7923076923078,50.36538461538461 817.1242156806925,74.65674998576554 858,75 C 898.8757843193075,75.34325001423446 942.2954449695382,51.738384672322496 978,49 C 1013.7045550304618,46.261615327677504 1041.6940044411547,64.38971132494447 1080,68 C 1118.3059955588453,71.61028867505553 1166.928537265843,60.702770027899575 1207,62 C 1247.071462734157,63.297229972100425 1278.5918464954734,76.79920856345726 1316,81 C 1353.4081535045266,85.20079143654274 1396.7040767522633,80.10039571827137 1440,75 L 1440,400 L 0,400 Z");
                        }

                        100% {
                            d: path("M 0,400 L 0,75 C 52.542912182808564,69.16958757995027 105.08582436561713,63.33917515990055 140,62 C 174.91417563438287,60.66082484009945 192.19961472034004,63.812886940348086 232,60 C 271.80038527965996,56.187113059651914 334.11571675302247,45.40927707870713 381,54 C 427.88428324697753,62.59072292129287 459.3375182675701,90.5500047448234 486,98 C 512.6624817324299,105.4499952551766 534.5342101766972,92.39070394199928 580,87 C 625.4657898233028,81.60929605800072 694.525641025641,83.8871794871795 736,75 C 777.474358974359,66.1128205128205 791.3632257207388,46.06057810928278 827,53 C 862.6367742792612,59.93942189071722 920.0214560914043,93.8705080756894 966,105 C 1011.9785439085957,116.1294919243106 1046.5509499136442,104.45738958795954 1086,96 C 1125.4490500863558,87.54261041204046 1169.774744254019,82.29993357247243 1206,75 C 1242.225255745981,67.70006642752757 1270.3500730702801,58.342876122150734 1308,58 C 1345.6499269297199,57.657123877849266 1392.82496346486,66.32856193892464 1440,75 L 1440,400 L 0,400 Z");
                        }
                    }
                </style>
                <defs>
                    <linearGradient id="gradient" x1="4%" y1="70%" x2="96%" y2="30%">
                        <stop offset="5%" stop-color="#6ffcc8"></stop>
                        <stop offset="95%" stop-color="#226e6a"></stop>
                    </linearGradient>
                </defs>
                <path d="M 0,400 L 0,75 C 52.542912182808564,69.16958757995027 105.08582436561713,63.33917515990055 140,62 C 174.91417563438287,60.66082484009945 192.19961472034004,63.812886940348086 232,60 C 271.80038527965996,56.187113059651914 334.11571675302247,45.40927707870713 381,54 C 427.88428324697753,62.59072292129287 459.3375182675701,90.5500047448234 486,98 C 512.6624817324299,105.4499952551766 534.5342101766972,92.39070394199928 580,87 C 625.4657898233028,81.60929605800072 694.525641025641,83.8871794871795 736,75 C 777.474358974359,66.1128205128205 791.3632257207388,46.06057810928278 827,53 C 862.6367742792612,59.93942189071722 920.0214560914043,93.8705080756894 966,105 C 1011.9785439085957,116.1294919243106 1046.5509499136442,104.45738958795954 1086,96 C 1125.4490500863558,87.54261041204046 1169.774744254019,82.29993357247243 1206,75 C 1242.225255745981,67.70006642752757 1270.3500730702801,58.342876122150734 1308,58 C 1345.6499269297199,57.657123877849266 1392.82496346486,66.32856193892464 1440,75 L 1440,400 L 0,400 Z" stroke="none" stroke-width="0" fill="url(#gradient)" fill-opacity="0.4" class="transition-all duration-300 ease-in-out delay-150 path-0"></path>

                <style>
                    .path-1 {
                        animation: pathAnim-1 4s;
                        animation-timing-function: linear;
                        animation-iteration-count: infinite;
                    }

                    @keyframes pathAnim-1 {
                        0% {
                            d: path("M 0,400 L 0,175 C 49.07970544136346,181.83559566512935 98.15941088272692,188.67119133025867 133,185 C 167.84058911727308,181.32880866974133 188.44206191045572,167.15083034409457 220,159 C 251.55793808954428,150.84916965590543 294.07234147545023,148.72548729336296 342,154 C 389.92765852454977,159.27451270663704 443.2685721877432,171.94722048245364 482,173 C 520.7314278122568,174.05277951754636 544.853369773577,163.4856307768225 583,153 C 621.146630226423,142.5143692231775 673.3179487179488,132.1102564102564 715,138 C 756.6820512820512,143.8897435897436 787.8748353546281,166.07334358215186 832,178 C 876.1251646453719,189.92665641784814 933.1827098635391,191.5963692611361 971,188 C 1008.8172901364609,184.4036307388639 1027.3943251912162,175.54117937330375 1059,169 C 1090.6056748087838,162.45882062669625 1135.2399893715956,158.238913245649 1182,164 C 1228.7600106284044,169.761086754351 1277.6457173224014,185.50316764410027 1321,189 C 1364.3542826775986,192.49683235589973 1402.1771413387992,183.74841617794988 1440,175 L 1440,400 L 0,400 Z");
                        }

                        25% {
                            d: path("M 0,400 L 0,175 C 48.86484465448197,198.69715120803204 97.72968930896394,222.39430241606405 137,212 C 176.27031069103606,201.60569758393595 205.94608741862623,157.11994154377575 246,144 C 286.05391258137377,130.88005845622425 336.485961016531,149.12593140883297 371,154 C 405.514038983469,158.87406859116703 424.11006851524996,150.37633282089243 464,152 C 503.88993148475004,153.62366717910757 565.0737649224695,165.3687373075974 605,176 C 644.9262350775305,186.6312626924026 663.5948717948719,196.14871794871794 698,193 C 732.4051282051281,189.85128205128206 782.5467478980432,174.0363908975308 826,177 C 869.4532521019568,179.9636091024692 906.218136612955,201.70571846115885 945,205 C 983.781863387045,208.29428153884115 1024.580705650136,193.1407352578337 1065,190 C 1105.419294349864,186.8592647421663 1145.459040786502,195.7313405075063 1189,191 C 1232.540959213498,186.2686594924937 1279.5831312038567,167.93390271214108 1322,163 C 1364.4168687961433,158.06609728785892 1402.2084343980716,166.53304864392948 1440,175 L 1440,400 L 0,400 Z");
                        }

                        50% {
                            d: path("M 0,400 L 0,175 C 32.21540074778417,161.89411167416347 64.43080149556835,148.78822334832697 103,152 C 141.56919850443165,155.21177665167303 186.49219476551082,174.74121828085558 227,182 C 267.5078052344892,189.25878171914442 303.6004194423883,184.24690352825067 341,191 C 378.3995805576117,197.75309647174933 417.10612746493587,216.27116760614172 461,209 C 504.89387253506413,201.72883239385828 553.9750706978685,168.66842604718252 594,154 C 634.0249293021315,139.33157395281748 664.9935897435897,143.0551282051282 704,151 C 743.0064102564103,158.9448717948718 790.0505703277723,171.11106113230466 828,170 C 865.9494296722277,168.88893886769534 894.8041289453207,154.5006272656532 940,166 C 985.1958710546793,177.4993727343468 1046.732913890945,214.88642980508263 1095,210 C 1143.267086109055,205.11357019491737 1178.2642154908992,157.9536535140162 1211,145 C 1243.7357845091008,132.0463464859838 1274.2102241454572,153.2989561388525 1312,164 C 1349.7897758545428,174.7010438611475 1394.8948879272714,174.85052193057373 1440,175 L 1440,400 L 0,400 Z");
                        }

                        75% {
                            d: path("M 0,400 L 0,175 C 46.21936362428589,184.04731822581564 92.43872724857178,193.0946364516313 127,189 C 161.56127275142822,184.9053635483687 184.46445462999867,167.66877241929052 226,172 C 267.53554537000133,176.33122758070948 327.7034542314335,202.23027387120655 374,202 C 420.2965457685665,201.76972612879345 452.72172844426734,175.41013209588337 490,173 C 527.2782715557327,170.58986790411663 569.4096319914972,192.12919774525992 614,203 C 658.5903680085028,213.87080225474008 705.6397435897436,214.07307692307694 740,195 C 774.3602564102564,175.92692307692306 796.0313936495284,137.57849456243235 835,143 C 873.9686063504716,148.42150543756765 930.2346818121429,197.61294482719356 971,211 C 1011.7653181878571,224.38705517280644 1037.0298791019,201.96972612879347 1078,195 C 1118.9701208981,188.03027387120653 1175.6458017802577,196.5081506576325 1215,192 C 1254.3541982197423,187.4918493423675 1276.3869137770691,169.99767124067642 1311,165 C 1345.6130862229309,160.00232875932358 1392.8065431114655,167.5011643796618 1440,175 L 1440,400 L 0,400 Z");
                        }

                        100% {
                            d: path("M 0,400 L 0,175 C 49.07970544136346,181.83559566512935 98.15941088272692,188.67119133025867 133,185 C 167.84058911727308,181.32880866974133 188.44206191045572,167.15083034409457 220,159 C 251.55793808954428,150.84916965590543 294.07234147545023,148.72548729336296 342,154 C 389.92765852454977,159.27451270663704 443.2685721877432,171.94722048245364 482,173 C 520.7314278122568,174.05277951754636 544.853369773577,163.4856307768225 583,153 C 621.146630226423,142.5143692231775 673.3179487179488,132.1102564102564 715,138 C 756.6820512820512,143.8897435897436 787.8748353546281,166.07334358215186 832,178 C 876.1251646453719,189.92665641784814 933.1827098635391,191.5963692611361 971,188 C 1008.8172901364609,184.4036307388639 1027.3943251912162,175.54117937330375 1059,169 C 1090.6056748087838,162.45882062669625 1135.2399893715956,158.238913245649 1182,164 C 1228.7600106284044,169.761086754351 1277.6457173224014,185.50316764410027 1321,189 C 1364.3542826775986,192.49683235589973 1402.1771413387992,183.74841617794988 1440,175 L 1440,400 L 0,400 Z");
                        }
                    }
                </style>
                <defs>
                    <linearGradient id="gradient" x1="4%" y1="70%" x2="96%" y2="30%">
                        <stop offset="5%" stop-color="#6ffcc8"></stop>
                        <stop offset="95%" stop-color="#226e6a"></stop>
                    </linearGradient>
                </defs>
                <path d="M 0,400 L 0,175 C 49.07970544136346,181.83559566512935 98.15941088272692,188.67119133025867 133,185 C 167.84058911727308,181.32880866974133 188.44206191045572,167.15083034409457 220,159 C 251.55793808954428,150.84916965590543 294.07234147545023,148.72548729336296 342,154 C 389.92765852454977,159.27451270663704 443.2685721877432,171.94722048245364 482,173 C 520.7314278122568,174.05277951754636 544.853369773577,163.4856307768225 583,153 C 621.146630226423,142.5143692231775 673.3179487179488,132.1102564102564 715,138 C 756.6820512820512,143.8897435897436 787.8748353546281,166.07334358215186 832,178 C 876.1251646453719,189.92665641784814 933.1827098635391,191.5963692611361 971,188 C 1008.8172901364609,184.4036307388639 1027.3943251912162,175.54117937330375 1059,169 C 1090.6056748087838,162.45882062669625 1135.2399893715956,158.238913245649 1182,164 C 1228.7600106284044,169.761086754351 1277.6457173224014,185.50316764410027 1321,189 C 1364.3542826775986,192.49683235589973 1402.1771413387992,183.74841617794988 1440,175 L 1440,400 L 0,400 Z" stroke="none" stroke-width="0" fill="url(#gradient)" fill-opacity="0.53" class="transition-all duration-300 ease-in-out delay-150 path-1"></path>

                <style>
                    .path-2 {
                        animation: pathAnim-2 4s;
                        animation-timing-function: linear;
                        animation-iteration-count: infinite;
                    }

                    @keyframes pathAnim-2 {
                        0% {
                            d: path("M 0,400 L 0,275 C 39.45802444533014,265.5846334149443 78.91604889066028,256.1692668298886 123,264 C 167.08395110933972,271.8307331701114 215.793828882689,296.90756609538994 249,303 C 282.206171117311,309.09243390461006 299.90863557858376,296.2004687885517 341,296 C 382.09136442141624,295.7995312114483 446.5716288029761,308.2905587504033 494,303 C 541.4283711970239,297.7094412495967 571.8048492095123,274.6372962098351 609,259 C 646.1951507904877,243.3627037901649 690.2089743589743,235.1602564102564 730,241 C 769.7910256410257,246.8397435897436 805.3592533545902,266.7216781491392 838,278 C 870.6407466454098,289.2783218508608 900.3540122226651,291.9530309931864 947,293 C 993.6459877773349,294.0469690068136 1057.2246977547495,293.466197878115 1095,284 C 1132.7753022452505,274.533802121885 1144.7471967583367,256.1821774943537 1180,250 C 1215.2528032416633,243.8178225056463 1273.7865152119039,249.8050921444704 1321,256 C 1368.2134847880961,262.1949078555296 1404.106742394048,268.59745392776483 1440,275 L 1440,400 L 0,400 Z");
                        }

                        25% {
                            d: path("M 0,400 L 0,275 C 33.71396970904743,260.9143606824954 67.42793941809487,246.8287213649908 107,242 C 146.57206058190513,237.1712786350092 192.00221203666797,241.59947522253225 236,253 C 279.99778796333203,264.40052477746775 322.56321243523314,282.7733777448803 357,293 C 391.43678756476686,303.2266222551197 417.7449382223994,305.3070137979464 464,301 C 510.2550617776006,296.6929862020536 576.4570346751693,285.99856706333384 621,278 C 665.5429653248307,270.00143293666616 688.4269230769231,264.698717948718 715,257 C 741.5730769230769,249.30128205128202 771.8352730171383,239.2065611417943 818,243 C 864.1647269828617,246.7934388582057 926.2319848545238,264.47503748410486 973,264 C 1019.7680151454762,263.52496251589514 1051.236787564767,244.89328892178636 1090,245 C 1128.763212435233,245.10671107821364 1174.8208648864088,263.95180682874985 1216,279 C 1257.1791351135912,294.04819317125015 1293.4797528895974,305.2994837632143 1330,304 C 1366.5202471104026,302.7005162367857 1403.2601235552013,288.85025811839284 1440,275 L 1440,400 L 0,400 Z");
                        }

                        50% {
                            d: path("M 0,400 L 0,275 C 45.38679041166088,259.35621097382756 90.77358082332177,243.71242194765512 132,255 C 173.22641917667823,266.2875780523449 210.2924671183738,304.5065231832071 249,305 C 287.7075328816262,305.4934768167929 328.05655070318284,268.26148531951645 367,263 C 405.94344929681716,257.73851468048355 443.4813300688948,284.44753553872727 477,289 C 510.5186699311052,293.55246446127273 540.0181290212379,275.9483725255746 584,275 C 627.9818709787621,274.0516274744254 686.4461538461537,289.75897435897434 731,294 C 775.5538461538463,298.24102564102566 806.1972555941469,291.01573003852803 843,279 C 879.8027444058531,266.98426996147197 922.7648237772589,250.17810548691375 968,255 C 1013.2351762227411,259.82189451308625 1060.7434492968173,286.2718480138169 1100,299 C 1139.2565507031827,311.7281519861831 1170.2613790354721,310.73450245781845 1202,309 C 1233.7386209645279,307.26549754218155 1266.2110345612937,304.790142154909 1306,299 C 1345.7889654387063,293.209857845091 1392.8944827193532,284.10492892254547 1440,275 L 1440,400 L 0,400 Z");
                        }

                        75% {
                            d: path("M 0,400 L 0,275 C 32.561900017081356,286.29986714494487 65.12380003416271,297.59973428988974 104,291 C 142.8761999658373,284.40026571011026 188.06669988043046,259.9009299853859 235,256 C 281.93330011956954,252.09907001461409 330.60940044411547,268.7965457685665 376,268 C 421.39059955588453,267.2034542314335 463.4956983431076,248.91288694034807 500,257 C 536.5043016568924,265.0871130596519 567.4078061834539,299.5519064700412 607,301 C 646.5921938165461,302.4480935299588 694.8730769230768,270.8794871794871 736,272 C 777.1269230769232,273.1205128205129 811.0998861242385,306.93014481201016 852,311 C 892.9001138757615,315.06985518798984 940.7273785799692,289.3999335724724 979,283 C 1017.2726214200308,276.6000664275276 1045.9905995558847,289.47012089810016 1085,283 C 1124.0094004441153,276.52987910189984 1173.3102231964926,250.71958283512686 1212,243 C 1250.6897768035074,235.28041716487314 1278.768507658145,245.65154776139235 1315,254 C 1351.231492341855,262.34845223860765 1395.6157461709277,268.67422611930385 1440,275 L 1440,400 L 0,400 Z");
                        }

                        100% {
                            d: path("M 0,400 L 0,275 C 39.45802444533014,265.5846334149443 78.91604889066028,256.1692668298886 123,264 C 167.08395110933972,271.8307331701114 215.793828882689,296.90756609538994 249,303 C 282.206171117311,309.09243390461006 299.90863557858376,296.2004687885517 341,296 C 382.09136442141624,295.7995312114483 446.5716288029761,308.2905587504033 494,303 C 541.4283711970239,297.7094412495967 571.8048492095123,274.6372962098351 609,259 C 646.1951507904877,243.3627037901649 690.2089743589743,235.1602564102564 730,241 C 769.7910256410257,246.8397435897436 805.3592533545902,266.7216781491392 838,278 C 870.6407466454098,289.2783218508608 900.3540122226651,291.9530309931864 947,293 C 993.6459877773349,294.0469690068136 1057.2246977547495,293.466197878115 1095,284 C 1132.7753022452505,274.533802121885 1144.7471967583367,256.1821774943537 1180,250 C 1215.2528032416633,243.8178225056463 1273.7865152119039,249.8050921444704 1321,256 C 1368.2134847880961,262.1949078555296 1404.106742394048,268.59745392776483 1440,275 L 1440,400 L 0,400 Z");
                        }
                    }
                </style>
                <defs>
                    <linearGradient id="gradient" x1="4%" y1="70%" x2="96%" y2="30%">
                        <stop offset="5%" stop-color="#6ffcc8"></stop>
                        <stop offset="95%" stop-color="#226e6a"></stop>
                    </linearGradient>
                </defs>
                <path d="M 0,400 L 0,275 C 39.45802444533014,265.5846334149443 78.91604889066028,256.1692668298886 123,264 C 167.08395110933972,271.8307331701114 215.793828882689,296.90756609538994 249,303 C 282.206171117311,309.09243390461006 299.90863557858376,296.2004687885517 341,296 C 382.09136442141624,295.7995312114483 446.5716288029761,308.2905587504033 494,303 C 541.4283711970239,297.7094412495967 571.8048492095123,274.6372962098351 609,259 C 646.1951507904877,243.3627037901649 690.2089743589743,235.1602564102564 730,241 C 769.7910256410257,246.8397435897436 805.3592533545902,266.7216781491392 838,278 C 870.6407466454098,289.2783218508608 900.3540122226651,291.9530309931864 947,293 C 993.6459877773349,294.0469690068136 1057.2246977547495,293.466197878115 1095,284 C 1132.7753022452505,274.533802121885 1144.7471967583367,256.1821774943537 1180,250 C 1215.2528032416633,243.8178225056463 1273.7865152119039,249.8050921444704 1321,256 C 1368.2134847880961,262.1949078555296 1404.106742394048,268.59745392776483 1440,275 L 1440,400 L 0,400 Z" stroke="none" stroke-width="0" fill="url(#gradient)" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-2"></path>
            </svg>
        </div>
    </div>

    <span class="absolute bottom-4 left-4 text-primary shadow-sm">&copy; <?= date('Y') ?> | Act Gate All Rights Reserved</span>

    <!-- <footer class="w-full h-[500px] bg-white">
    </footer> -->
</body>

</html>