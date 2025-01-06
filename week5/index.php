<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Student Information</title>
</head>

<body>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md">
        <div class="max-w-screen-lg flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="./public/images/school.png" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Student's</span>
            </a>

            <div class="flex w-1/3 justify-end gap-3">
                <a href="./pages/register.php" class="px-3 py-2 bg-green-500 rounded-md text-semibold text-md text-white hover:bg-green-700">+ Add Student</a>
            </div>
        </div>
    </nav>

    <div class="flex flex-col w-full justify-center items-center">
        <div class="flex flex-col w-full max-w-screen-lg p-5">

            <!-- Table -->
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <caption class="p-5 text-lg font-semibold text-center text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                    <span>Total Student: <?php
                                                            session_start();

                                                            if (!isset($_SESSION["students"]) || empty($_SESSION["students"])) {
                                                                echo 0;
                                                            } else {
                                                                $students = json_decode($_SESSION["students"]);
                                                                echo count($students);
                                                            }
                                                            ?></span>
                                </caption>
                                <thead class="bg-gray-200 rounded-tl-md rounded-tr-md">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Name</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Age</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">year</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Grade</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Birthday</th>
                                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-600 uppercase"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">

                                    <?php

                                    $_SESSION["students"] = json_encode([
                                        [
                                            "prefix" => "Mr",
                                            "name" => "John Doe",
                                            "age" => 18,
                                            "year" => 2,
                                            "grade" => 3.75,
                                            "birthday" => "7/09/2002"
                                        ],
                                    ]);

                                    if (!isset($_SESSION["students"]) || empty($_SESSION["students"])) {
                                        return;
                                    }

                                    $students = json_decode($_SESSION["students"], true);

                                    $students[] = [
                                        "prefix" => "Mr",
                                        "name" => "Theeraphat CH",
                                        "age" => 21,
                                        "year" => 1,
                                        "grade" => 3.21,
                                        "birthday" => "27/09/2004"
                                    ];

                                    $_SESSION["students"] = json_encode($students);

                                    $students = json_decode($_SESSION["students"]);

                                    foreach ($students as $student) {
                                        echo "<tr class='hover:bg-gray-100'>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800'>{$student->prefix}. {$student->name}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->age}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->year}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->grade}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->birthday}</td>
                                                <td class='flex gap-3 px-6 py-4 whitespace-nowrap text-end text-sm font-medium'>
                                                    <button type='button' class='inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none'>Edit</button>
                                                    <button type='button' class='inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none'>Delete</button>
                                                </td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>