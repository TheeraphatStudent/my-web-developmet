<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Student Information</title>
</head>

<body>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-[72px]">
        <div class="max-w-screen-lg flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="./public/images/school.png" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Student's</span>
            </a>

            <div class="flex w-1/3 justify-end gap-3">
                <button id="add-student-btn" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                    + Add student
                </button>
                <!-- <a href="./pages/register.php" class="px-3 py-2 bg-green-500 rounded-md text-semibold text-md text-white hover:bg-green-700">+ Add Student</a> -->
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
                                    <span>Total Students: <?php
                                                            if (!isset($_SESSION["students"]) || empty($_SESSION["students"])) {
                                                                echo 0;
                                                            } else {
                                                                $students = json_decode($_SESSION["students"], true);
                                                                echo count($students);
                                                            }
                                                            ?></span>

                                </caption>
                                <thead class="bg-gray-200 rounded-tl-md rounded-tr-md">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Id</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Name</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">year</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Grade</th>
                                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-600 uppercase">Birthday</th>
                                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-600 uppercase"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">

                                    <?php

                                    // $_SESSION["students"] = json_encode([
                                    //     [
                                    //         "prefix" => "Mr",
                                    //         "name" => "John Doe",
                                    //         "age" => 18,
                                    //         "year" => 2,
                                    //         "grade" => 3.75,
                                    //         "birthday" => "7/09/2002"
                                    //     ],
                                    // ]);

                                    if (isset($_SESSION["students"]) || !empty($_SESSION["students"])) {
                                        $students = json_decode($_SESSION["students"], true);

                                        $_SESSION["students"] = json_encode($students);

                                        $students = json_decode($_SESSION["students"]);

                                        foreach ($students as $student) {
                                            echo "<tr class='hover:bg-gray-100'>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->stdid}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800'>{$student->prefix}. {$student->name}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->year}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->grade}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-800'>{$student->birthday}</td>
                                                <td class='flex gap-3 px-6 py-4 whitespace-nowrap text-end text-sm font-medium'>
                                                    <button type='button' onclick='window.location.href=\"edited.php?stdid=$student->stdid\"' class='inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none'>Edit</button>
                                                    <form action='./deleted.php' method='post' style='display:inline;'>
                                                        <input type='hidden' name='stdid' value='{$student->stdid}'>
                                                        <button type='submit' class='inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-none focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none'>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        }
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

    <!-- Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Student Information <span class="text-green-500/50">(Added student)</span>
                    </h3>
                    <button type="button" class="text-red-400 bg-transparent hover:bg-red-200 hover:text-red-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-red-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form action="./submitted.php" method="post" id="added_student_form">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="name">
                                Student ID :
                            </label>
                            <div class="flex">
                                <input
                                    required
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="stdid" name="stdid" type="text" placeholder="Student Id">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="name">
                                Fullname :
                            </label>
                            <div class="flex">
                                <select required name="prefix" id="prefix" class="shadow bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-tl-lg rounded-bl-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Choose Prefix</option>
                                    <option value="Mr">Mr.</option>
                                    <option value="Mrs">Mrs.</option>
                                </select>
                                <input
                                    required
                                    class="shadow appearance-none border rounded-tr-lg rounded-br-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    name="name" id="name" type="text" placeholder="Student name">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="year">
                                Year :
                            </label>
                            <div class="flex">
                                <select required name="year" id="year" class="shadow bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>Choose year</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex mb-4 gap-5">
                            <div class="w-full">
                                <label class="block text-gray-700 font-bold mb-2" for="grade">
                                    Grade :
                                </label>
                                <div class="flex">
                                    <input
                                        required
                                        class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        name="grade" id="grade" type="text" placeholder="Average Grade">
                                </div>
                            </div>
                            <div class="w-full">
                                <label class="block text-gray-700 font-bold mb-2" for="birthday">
                                    Birthday :
                                </label>
                                <div class="flex">
                                    <input
                                        required
                                        class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        name="birthday" id="birthday" type="date" placeholder="Birthday">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" onclick="validateAndSubmitForm();" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Add student</button>
                    <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function validateAndSubmitForm() {
            const form = document.getElementById('added_student_form');
            const inputs = form.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value) {
                    isValid = false;
                }
            });

            if (isValid) {
                form.submit();
            }
        }
    </script>

    <script>
        document.getElementById('default-modal').classList.add('hidden')

        document.getElementById('add-student-btn').addEventListener('click', function() {
            document.getElementById('default-modal').classList.toggle('hidden');
        });

        document.querySelectorAll('[data-modal-hide]').forEach(function(element) {
            element.addEventListener('click', function() {
                document.getElementById('default-modal').classList.add('hidden');
            });
        });
    </script>

</body>

</html>