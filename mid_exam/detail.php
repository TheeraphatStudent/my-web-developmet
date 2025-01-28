<?php
// PHP code (if any) goes here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Phone Detail</title>
</head>

<body class="bg-gray-100">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-[72px]">
        <div class="flex max-w-screen-lg flex-wrap items-center justify-between mx-auto p-4 h-full">
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">CS MSU Mobile Shop - 66011212103</span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="w-full md:w-1/2">
                <img id="phone_img" alt="Phone Image" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col w-full md:w-1/2 p-6 items-start justify-center">
                <h3 id="phone_model" class="text-3xl font-semibold mb-4"></h3>
                <div class="flex flex-col w-full space-y-2">
                    <div class="flex">
                        <div class="w-1/2">ชิปประมวลผล:</div>
                        <p class="w-full" id="phone_cpu"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2">หน่วยความจำ:</div>
                        <p class="w-full" id="phone_ram"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2">กล้อง:</div>
                        <p class="w-full" id="phone_camera"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2">หน้าจอ:</div>
                        <p class="w-full" id="phone_screen"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2">ความละเอียด:</div>
                        <p class="w-full" id="phone_dimensions"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2">แบตเตอรี่:</div>
                        <p class="w-full" id="phone_battery"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2">เสียงวิดีโอ:</div>
                        <p class="w-full" id="phone_video"></p>
                    </div>
                    <div class="flex">
                        <div class="w-1/2"></div>
                        <p class="w-full font-bold text-xl">ราคา <span id="phone_price"></span> บาท</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedPhone = JSON.parse(localStorage.getItem('phone'));
            console.log(selectedPhone);

            if (selectedPhone) {
                document.getElementById('phone_img').src = selectedPhone.image;
                document.getElementById('phone_model').textContent = selectedPhone.model ?? '-';
                document.getElementById('phone_cpu').textContent = selectedPhone.cpu ?? '-';
                document.getElementById('phone_ram').textContent = selectedPhone.ram ?? '-';
                document.getElementById('phone_camera').textContent = selectedPhone.camera ?? '-';
                document.getElementById('phone_screen').textContent = selectedPhone.screen ?? '-';
                document.getElementById('phone_dimensions').textContent = selectedPhone.size ?? '-';
                document.getElementById('phone_battery').textContent = selectedPhone.battery ?? '-';
                document.getElementById('phone_video').textContent = selectedPhone.image_video ?? '-';
                document.getElementById('phone_price').textContent = selectedPhone.price ?? '-';
            }

            localStorage.removeItem('phone');
        });
    </script>
</body>

</html>