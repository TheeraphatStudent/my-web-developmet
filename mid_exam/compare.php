<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Compare</title>
</head>

<body class="bg-gray-100">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-[72px]">
        <div class="flex max-w-screen-lg flex-wrap items-center justify-between mx-auto p-4 h-full">
            <!-- <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse" onclick="window.localStorage.removeItem('phones')"> -->
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">CS MSU Mobile Shop - 66011212103</span>
            </a>
        </div>
    </nav>
    <div class="container mx-auto mt-8 p-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full table-auto">
                <caption class="my-5">
                    <span>จำนวนมือถือที่เลือกเปรียบเทียบ: <span class="" id="selectedCount"></span></span>
                </caption>
                <thead>
                    <tr id="imageRow">
                        <th class="p-2 border w-1/4"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td scope="col" style="min-width: 100px; max-width: 100px;" class="flex justify-end"><span>Model</span></td>
                    </tr> -->
                    <tr>
                        <td scope="col" style="min-width: 200px; max-width: 200px;" class="flex justify-end"><span>หน่วยประมวลผล</span></td>
                    </tr>
                    <tr>
                        <td scope="col" style="min-width: 200px; max-width: 200px;" class="flex justify-end"><span>หน่วยความจำ</span></td>
                    </tr>
                    <tr>
                        <td scope="col" style="min-width: 200px; max-width: 200px;" class="flex justify-end"><span>กล้อง</span></td>
                    </tr>
                    <tr>
                        <td scope="col" style="min-width: 200px; max-width: 200px;" class="flex justify-end"><span>หน้าจอ</span></td>
                    </tr>
                    <tr>
                        <td scope="col" style="min-width: 200px; max-width: 200px;" class="flex justify-end"><span>แบตเตอรี่</span></td>
                    </tr>
                    <tr>
                        <td scope="col" style="min-width: 200px; max-width: 200px;" class="flex justify-end"><span>เสียงและวิดีโอ</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedPhones = JSON.parse(localStorage.getItem('phones'));
            const selectedCount = document.getElementById('selectedCount').textContent = Object.keys(selectedPhones).length;;

            if (selectedPhones && Object.keys(selectedPhones).length > 0) {
                const imageRow = document.getElementById('imageRow');
                const rows = document.querySelectorAll('tbody tr');

                // [{}, {}, {}]
                // {}
                // [{}, {}]

                Object.values(selectedPhones).forEach((phone) => {
                    // Image
                    const imageCell = document.createElement('th');
                    imageCell.className = 'p-5 border w-1/4';

                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'flex flex-col items-center w-full';

                    // Title
                    const title = document.createElement('span');
                    title.textContent = phone.model;
                    title.className = 'font-bold text-center mb-2';

                    // Image
                    const img = document.createElement('img');
                    img.src = phone.image;
                    img.alt = phone.model;
                    img.className = 'mx-auto max-w-full h-auto object-contain';
                    img.style.maxHeight = '180px';

                    imgContainer.appendChild(title);
                    imgContainer.appendChild(img);

                    imageCell.appendChild(imgContainer);
                    imageRow.appendChild(imageCell);

                    // Detail
                    rows[0].insertAdjacentHTML('beforeend', `<td class="p-5 pt-0 my-5 align-top">${phone.cpu}</td>`);
                    rows[1].insertAdjacentHTML('beforeend', `<td class="p-5 pt-0 my-5 align-top">${phone.ram}</td>`);
                    rows[2].insertAdjacentHTML('beforeend', `<td class="p-5 pt-0 my-5 align-top">${phone.camera}</td>`);
                    rows[3].insertAdjacentHTML('beforeend', `<td class="p-5 pt-0 my-5 align-top">${phone.screen}</td>`);
                    rows[4].insertAdjacentHTML('beforeend', `<td class="p-5 pt-0 my-5 align-top">${phone.battery}</td>`);
                    rows[5].insertAdjacentHTML('beforeend', `<td class="p-5 pt-0 my-5 align-top">${phone.image_video}</td>`);
                });

                // window.localStorage.removeItem('phones');
            }
        });
    </script>
</body>

</html>