<?php
include_once('./db/data.php');
include_once('./db/phone.php');

$usePhones = [];

foreach ($_SESSION['phones'] as $phone) {
    $usePhones[] = new Phone(
        $phone->id,
        $phone->model,
        $phone->cpu,
        $phone->ram,
        $phone->camera,
        $phone->screen,
        $phone->size,
        $phone->battery,
        $phone->image_video,
        $phone->image,
        $phone->price
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">

    <title>Welcome</title>
</head>

<body class="overflow-x-hidden">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-[72px] fixed top-0 w-screen z-50">
        <div class="flex max-w-screen-lg flex-wrap items-center justify-between mx-auto p-4">
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">CS MSU Mobile Shop - 66011212103</span>
            </a>

            <div class="flex w-fit justify-end gap-3">
                <button id="compare-phone-btn" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 rounded" type="button">
                    เปรียบเทียบ
                </button>
            </div>
        </div>
    </nav>

    <div class="flex w-full my-5 mt-28 justify-center">
        <span class="font-semibold text-black text-base"> > เลือกที่โทรศัพท์ที่ต้องการเปรียบเทียบ < </span>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($usePhones as $index => $phone) : ?>
                <div class="bg-white p-4 rounded shadow hover:bg-slate-300 transition-colors duration-300 hover:cursor-pointer phones relative group" id="content-<?php echo $index + 1; ?>">
                    <!-- Phone Id -->
                    <input type="text" class="hidden" id="uniq_id" value="<?php echo htmlspecialchars($phone->id) ?>">

                    <!-- Content -->
                    <img src="<?php echo htmlspecialchars($phone->image); ?>" alt="<?php echo htmlspecialchars($phone->model); ?>" class="w-fit h-fit object-cover mb-2">
                    <div class="flex flex-col items-center w-full h-fit justify-center gap-3">
                        <h2 class="text-xl font-bold"><?php echo htmlspecialchars($phone->model); ?></h2>
                        <p class="text-gray-600">ราคา: <?php echo htmlspecialchars($phone->price); ?> บาท</p>
                        <span class="flex h-fit items-center justify-center gap-3">
                            <input type="checkbox" id="checked-<?php echo $index + 1; ?>" class="phone-checkbox w-5 h-5 text-center">
                            <span>เลือกเพื่อเปรียบเทียบ</span>
                        </span>

                    </div>

                    <!-- Tooltip -->
                    <div
                        class="
                            absolute z-40 w-64 p-4 -mt-2 text-sm bg-white rounded-lg shadow-xl
                            opacity-0 group-hover:opacity-100 transition-opacity duration-300
                            right-1/2 top-0 left-1/2 ml-2 pointer-events-none">
                        <span class="font-semibold mb-2"><?php echo htmlspecialchars($phone->model); ?></span>
                        <p>CPU: <?php echo htmlspecialchars($phone->cpu); ?></p>
                        <p>RAM: <?php echo htmlspecialchars($phone->ram); ?></p>
                        <!-- <p>Camera: <?php echo htmlspecialchars($phone->camera); ?></p> -->
                        <p>Screen: <?php echo htmlspecialchars($phone->screen); ?></p>
                        <!-- <p>Size: <?php echo htmlspecialchars($phone->size); ?></p> -->
                        <!-- <p>Battery: <?php echo htmlspecialchars($phone->battery); ?></p> -->
                        <p>Price: <?php echo htmlspecialchars($phone->price); ?> บาท</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <script>
        const maxSelected = 3;
        const phones = document.querySelectorAll('.phones');
        const checkboxes = document.querySelectorAll('.phone-checkbox');

        const compare = document.getElementById('compare-phone-btn');

        let selectedCount = 0;
        let selectedPhones = {}

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                event.stopPropagation()

                const parentDiv = this.closest('div.phones');
                const phoneId = parentDiv.querySelector('#uniq_id').value;

                if (this.checked) {
                    if (selectedCount < maxSelected) {
                        parentDiv.classList.add('bg-slate-400');
                        parentDiv.classList.add('border-[2px]');
                        parentDiv.classList.add('border-slate-400');
                        selectedCount++;

                        selectedPhones[phoneId] = getPhoneById(phoneId);
                    } else {
                        this.checked = false;
                        alert('เปรียบเทียบได้สูงสุด 3 รุ่น!');
                    }
                } else {
                    parentDiv.classList.remove('bg-slate-400');
                    parentDiv.classList.remove('border-[2px]');
                    parentDiv.classList.remove('border-slate-400');
                    selectedCount--;

                    delete selectedPhones[phoneId];
                }

                console.log(selectedPhones);
            });
        });

        compare.addEventListener('click', function() {
            // if (selectedCount <= 1) {
            //     alert("จำเป็นต้องเลือกอย่างน้อย 2 รุ่นที่ต้องการเปรียบเทียบ!");

            //     return;
            // }

            window.localStorage.setItem('phones', JSON.stringify(selectedPhones));
            window.location.href = `./compare.php`;

        })

        phones.forEach((phone) => {
            phone.addEventListener('click', function() {
                if (event.target.type === 'checkbox') {
                    return;
                }

                const uniqIdInput = phone.querySelector('#uniq_id');

                if (uniqIdInput) {
                    const phoneId = uniqIdInput.value;
                    console.log(phoneId);

                    const selectedPhone = getPhoneById(phoneId);

                    if (selectedPhone) {
                        console.log(selectedPhone)
                        window.localStorage.setItem('phone', JSON.stringify(selectedPhone));
                        window.location.href = `./detail.php`;
                    }
                }
            });
        });

        const getPhoneById = (phoneId) => {
            return (<?php echo json_encode($usePhones); ?>).find((item) => item.id === phoneId);

        }
    </script>

    <script src="https://unpkg.com/@material-tailwind/html@latest/scripts/ripple.js"></script>

</body>

</html>