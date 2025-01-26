<?php
include(__DIR__ . '/../php/submitted.php');
require_once(__DIR__ . '/../php/user.php');
require_once(__DIR__ . '/../php/connected.php');

$std = new Student();

if (isset($_GET['uniq_id'])) {
    $uniq_id = $_GET['uniq_id'];
    $student = $std->getInfoByUniqId($uniq_id);
}

$init = new Init();
$connection = $init->getConnected();

$user = new User($connection);

if (isset($_SESSION['token'])) {
    $userToken = $_SESSION['token'];
    $isValid = $user->validateToken($userToken);

    // print_r($userToken);
    // print_r($isValid);

    if (!$isValid['valid']) {
        header('Location: ../');
        exit;
    }
} else {
    header('Location: ../');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>Student Information</title>
</head>

<body>
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-[72px]">
        <div class="max-w-screen-lg flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="./" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="../public/images/school.png" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Student's / <?php echo ($student->getStdID()) ?></span>
            </a>
        </div>
    </nav>

    <div class="flex flex-col w-full justify-center items-center">
        <div class="flex flex-col w-full max-w-screen-lg p-5">

            <!-- body -->
            <div class="p-4 md:p-5 space-y-4">
                <form action="../php/submitted.php" method="post" id="added_student_form">
                    <input type="hidden" name="uniq_id" id="uniq_id" value="<?php echo ($student->getUniqID()) ?>">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="stdid">
                            Student ID :
                        </label>
                        <div class="flex">
                            <input
                                required
                                class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="stdid" name="stdid" type="text" placeholder="Student Id" value="<?php echo ($student->getStdID()) ?>">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="name">
                            Fullname :
                        </label>
                        <div class="flex">
                            <select required name="prefix" id="prefix" class="shadow bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-tl-lg rounded-bl-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Choose Prefix</option>
                                <option value="Mr" <?php echo ($student->getPrefix() == 'Mr') ? 'selected' : ''; ?>>Mr.</option>
                                <option value="Mrs" <?php echo ($student->getPrefix() == 'Mrs') ? 'selected' : ''; ?>>Mrs.</option>
                            </select>
                            <input
                                required
                                class="shadow appearance-none border rounded-tr-lg rounded-br-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="name" id="name" type="text" placeholder="Student name" value="<?php echo ($student->getName()) ?>">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="year">
                            Year :
                        </label>
                        <div class="flex">
                            <select required name="year" id="year" class="shadow bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Choose year</option>
                                <option value="1" <?php echo ($student->getYear() == '1') ? 'selected' : '' ?>>1</option>
                                <option value="2" <?php echo ($student->getYear() == '2') ? 'selected' : '' ?>>2</option>
                                <option value="3" <?php echo ($student->getYear() == '3') ? 'selected' : '' ?>>3</option>
                                <option value="4" <?php echo ($student->getYear() == '4') ? 'selected' : '' ?>>4</option>
                                <option value="5" <?php echo ($student->getYear() == '5') ? 'selected' : '' ?>>5</option>
                                <option value="6" <?php echo ($student->getYear() == '6') ? 'selected' : '' ?>>6</option>
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
                                    name="grade" id="grade" type="text" placeholder="Average Grade" value="<?php echo ($student->getGrade()) ?>">
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
                                    name="birthday" id="birthday" type="date" placeholder="Birthday" value="<?php echo ($student->getBirthday()) ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- footer -->
            <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" onclick="validateAndSubmitForm();" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Update student</button>
                <button type="button" onclick="window.location.href='./view.php'" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
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

</body>

</html>