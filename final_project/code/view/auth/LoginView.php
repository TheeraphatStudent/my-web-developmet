<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style/main.css">

    <title>Login</title>
</head>

<body class="flex w-screen h-screen items-center justify-around xl:flex-row flex-col">
    <div class="flex flex-col card gap-10 shadow-primary/40">
        <h3>ยินดีต้อนรับ</h3>

        <form class="space-y-4" id="loginForm" action="../?action=request&on=user&form=login" method="post">

            <div>
                <!-- <label class="text-gray-800 text-sm mb-2 block">ชื่อบัญชี</label> -->
                <div class="relative flex items-center">
                    <input autocomplete="username" name="username" type="text" requiredd class="input-field outline-green" placeholder="ชื่อผู้ใข้งาน" required />
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                        <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                        <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                    </svg>
                </div>
            </div>
            <div>
                <!-- <label class="text-gray-800 text-sm mb-2 block">รหัสผ่าน</label> -->
                <div class="relative flex items-center">
                    <input autocomplete="password" name="password" id="password" type="password" requiredd class="input-field outline-green password" placeholder="รหัสผ่าน" required minlength="10" />
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" id="togglePassword" viewBox="0 0 128 128" onclick="togglePasswordVisibility()">
                        <path id="eye-icon" d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-4">
                <!-- <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-green-600 focus:ring-green-500 border-gray-300 rounded" />
                    <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                        จดจำฉันไว้
                    </label>
                </div> -->

                <div class="text-sm">
                    <button type="button" class="text-primary hover:text-dark-primary underline hover:underline font-semibold" id="forgot-password-btn">
                        ลืมรหัสผ่าน?
                    </button>
                </div>
            </div>

            <div class="!mt-8">
                <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-primary hover:bg-dark-primary focus:outline-none">
                    เข้าใช้งาน
                </button>
            </div>

            <p class="text-sm !mt-8 text-center text-gray-500">ยังไม่มีบัญชีใช่ไหม?
                <a href="..?action=register" class="text-green-600 font-semibold hover:underline ml-1 whitespace-nowrap toggleForm">สร้างบัญชีเลย</a>
            </p>
        </form>
    </div>

    <img src="public/images/login.png" alt="" srcset="">

    <div id="resetPassModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold font-kanit text-primary">คืนค่ารหัสผ่าน</h3>
                <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Edit User -->
            <form
                id="resetPassForm"
                class="space-y-6"
                action="../?action=request&on=user&form=reset"
                method="post">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2 md:col-span-2">
                            <label for="username" class="text-sm font-medium text-gray-700">
                                ชื่อผู้ใช้&nbsp;
                                <span class="form-required">*</span>
                            </label>
                            <input type="text" id="username" name="username" class="w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="ระบุชื่อผู้ใช้งาน">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="email" class="text-sm font-medium text-gray-700">
                                อีเมล&nbsp;
                                <span class="form-required">*</span>
                            </label>
                            <input type="email" id="email" name="email" class="w-full rounded-lg border border-gray-300 px-3 py-2" placeholder="ระบุอีเมลที่สร้างบัญชี">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="email" class="text-sm font-medium text-gray-700">
                                รหัสผ่านใหม่&nbsp;
                                <span class="form-required">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <input name="password" id="resetPassword" type="password" requiredd class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-green password" placeholder="รหัสผ่าน" required minlength="10" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" id="togglePassword" viewBox="0 0 128 128" onclick="togglePasswordVisibility()">
                                    <path id="eye-icon" d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="email" class="text-sm font-medium text-gray-700">
                                ยืนยันรหัสผ่าน&nbsp;
                                <span class="form-required">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <input id="refPassword" type="password" requiredd class="w-full rounded-lg border border-gray-300 px-3 py-2 outline-green password" placeholder="รหัสผ่าน" required minlength="10" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" id="togglePassword" viewBox="0 0 128 128" onclick="togglePasswordVisibility()">
                                    <path id="eye-icon" d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancelEditBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">ยกเลิก</button>
                    <button type="button" id="confirmBtn" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-dark-primary">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const resetPassBtn = document.getElementById('forgot-password-btn');
        const resetModel = document.getElementById('resetPassModal');
        const closeModal = document.getElementById('closeModalBtn');

        const resetForm = document.getElementById('resetPassForm');

        const confirmBtn = document.getElementById('confirmBtn');
        const cancelBtn = document.getElementById('cancelEditBtn');

        resetPassBtn.addEventListener('click', () => {
            resetModel.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            resetModel.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            resetModel.classList.add('hidden');
        });

        resetModel.addEventListener('click', (e) => {
            if (e.target === resetModel) {
                resetModel.classList.add('hidden');
            }
        });

        confirmBtn.addEventListener('click', async () => {
            console.log("Clicked work")

            const password = document.getElementById('resetPassword').value;
            const confirmPassword = document.getElementById('refPassword').value;

            console.log(password)
            console.log(confirmPassword)

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านไม่ตรงกัน',
                    text: 'กรุณาตรวจสอบรหัสผ่านอีกครั้ง',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            const formData = new FormData(resetForm);

            const response = await fetch(resetForm.action, {
                method: resetForm.method,
                body: formData
            })

            const result = await response.json();

            try {


                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'รีเซ็ตรหัสผ่านสำเร็จ',
                        text: 'กรุณาเข้าสู่ระบบด้วยรหัสผ่านใหม่',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        resetModel.classList.add('hidden');
                        resetForm.reset();
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถรีเซ็ตรหัสผ่านได้',
                        text: data.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ลองใหม่อีกครั้ง'
                    });

                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: result?.message ?? 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                    confirmButtonColor: '#3085d6'
                });

            }
        });
    </script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(async (response) => {
                    const res = await response.json();

                    return res;
                })
                .then((data) => {
                    if (data.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'เข้าสู่ระบบสำเร็จ',
                            text: 'ยินดีต้อนรับเข้าสู่ระบบ',
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ไม่สามารถเข้าสู่ระบบได้',
                            text: data.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ลองใหม่อีกครั้ง'
                        });

                    }

                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                        confirmButtonColor: '#3085d6'
                    });
                });
        });
    </script>

</body>

</html>