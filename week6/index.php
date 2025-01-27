<?php
// require_once(__DIR__ . '/php/student.php');
// require_once(__DIR__ . '/php/submitted.php');
// require_once(__DIR__ . '/php/connected.php');

// $init = new Init();
// $connection = $init->getConnected();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/style.css">
    <title>Welcome!</title>
</head>

<body>
    <div class="font-[sans-serif]">
        <div class="min-h-screen flex fle-col items-center justify-center p-8">
            <div class="grid md:grid-cols-2 items-center gap-6 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">

                    <!-- Login Form -->
                    <form class="space-y-4" id="loginForm" action="./php/registered.php" method="get">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-bold titleForm">Sign in</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">ระบบจัดการข้อมูลนักเรียน</p>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">User name</label>
                            <div class="relative flex items-center">
                                <input name="username" type="text" requiredd class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-green-600" placeholder="Enter username" required />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                    <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input name="password" id="password" type="password" requiredd class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-green-600 password" placeholder="Enter password" required minlength="10" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer togglePassword" viewBox="0 0 128 128">
                                    <path id="eye-icon" d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-green-600 focus:ring-green-500 border-gray-300 rounded" />
                                <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                                    Remember me
                                </label>
                            </div>

                            <div class="text-sm">
                                <button type="button" class="text-orange-500 hover:underline font-semibold" id="forgot-password-btn">
                                    Forgot your password?
                                </button>
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                Sign in
                            </button>
                        </div>

                        <p class="text-sm !mt-8 text-center text-gray-500">Don't have an account
                            <a href="javascript:void(0);" class="text-green-600 font-semibold hover:underline ml-1 whitespace-nowrap toggleForm">Register here</a>
                        </p>
                    </form>

                    <!-- Register Form -->
                    <form class="space-y-4 hidden" id="registerForm" action="./php/registered.php" method="post">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-bold titleForm">Create account</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">ระบบจัดการข้อมูลนักเรียน</p>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">User name</label>
                            <div class="relative flex items-center">
                                <input name="username" type="text" requiredd class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-orange-600" placeholder="Enter username" required />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                    <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                                    <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input name="email" type="email" requiredd class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-orange-600" placeholder="Enter email" required />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                                    <path d="M0 4v16h24v-16h-24zm21.518 2l-9.518 7.713-9.518-7.713h19.036zm-19.518 12v-11.817l10 8.104 10-8.104v11.817h-20z" />
                                </svg>
                            </div>
                        </div>

                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input minlength="10" name="password" id="password" type="password" requiredd class="w-full text-sm text-gray-800 border border-gray-300 pl-4 pr-10 py-3 rounded-lg outline-orange-600 password" placeholder="Enter password" required />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer togglePassword" viewBox="0 0 128 128">
                                    <path id="eye-icon" d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none">
                                Already Done!
                            </button>
                        </div>

                        <p class="text-sm !mt-8 text-center text-gray-500">I have an account!
                            <a href="javascript:void(0);" class="text-orange-600 font-semibold hover:underline ml-1 whitespace-nowrap toggleForm">Login Here</a>
                        </p>
                    </form>

                </div>

                <div class="max-md:mt-8">
                    <img src="./public/images/cover-login.webp" id="coverImg" class="w-full aspect-[71/50] max-md:w-4/5 mx-auto block object-contain" alt="Cat Cooperation Service" />
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Form -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Reset password
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
                    <form action="./php/password.php" method="post" id="reset_password_form">
                        <input type="text" class="hidden" name="uniq_id" id="uniq_id" value="<?php echo uniqid(); ?>">

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="username">
                                Username :
                            </label>
                            <div class="flex">
                                <input
                                    required
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="username" name="username" type="text" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="email">
                                Email :
                            </label>
                            <div class="flex">
                                <input
                                    required
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="email" name="email" type="email" placeholder="Enter email">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="password">
                                Password :
                            </label>
                            <div class="flex">
                                <input
                                    required
                                    class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="password" name="password" type="password" placeholder="Enter password">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" id="confirmToResetPassword" onclick="validateAndSubmitForm('reset_password_form');" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Confirm</button>
                    <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                </div>

            </div>
        </div>
    </div>

    <script src="./script/modal.js"></script>
    <script>
        document.getElementById('forgot-password-btn').addEventListener('click', function() {
            document.getElementById('default-modal').classList.toggle('hidden');
        });

        const validateAndSubmitForm = (formId) => {
            const form = document.getElementById(formId);
            if (!form) {
                console.error(`Form with id "${formId}" not found`);
                return;
            }

            const inputs = form.querySelectorAll('input[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                }

            });

            if (isValid) {
                form.submit();
            }
        };
    </script>

    <!-- Login & Register Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.getElementsByTagName('input');

            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            });

            Array.from(inputs).forEach(input => {
                if (input.type === 'password') {
                    input.addEventListener('copy', function(e) {
                        e.preventDefault();
                        return false;
                    });
                }
            });

            // Form
            const registerForm = document.getElementById('registerForm');
            const loginForm = document.getElementById('loginForm');

            const toggleForms = document.querySelectorAll('.toggleForm');

            // Cover Img
            const coverImg = document.getElementById('coverImg');

            toggleForms.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    loginForm.classList.toggle('hidden');
                    registerForm.classList.toggle('hidden');


                    loginForm.classList.add('scale-30', 'opacity-0');
                    registerForm.classList.add('scale-30', 'opacity-0');
                    coverImg.classList.add('scale-90', 'opacity-0');

                    setTimeout(() => {
                        const imgUrl = loginForm.classList.contains('hidden') ?
                            './public/images/cover-register.webp' :
                            './public/images/cover-login.webp';

                        coverImg.src = imgUrl;

                        setTimeout(() => {
                            loginForm.classList.remove('scale-30', 'opacity-0');
                            registerForm.classList.remove('scale-30', 'opacity-0');
                            coverImg.classList.remove('scale-90', 'opacity-0');
                        }, 50);
                    }, 250);
                });
            });
        });
    </script>

    <!-- Password Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePasswordButtons = document.querySelectorAll('.togglePassword');
            const passwordInputs = document.querySelectorAll('.password');

            togglePasswordButtons.forEach((toggle, index) => {
                toggle.addEventListener('click', () => {
                    const type = passwordInputs[index].getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInputs[index].setAttribute('type', type);

                });
            });
        });
    </script>

</body>

</html>