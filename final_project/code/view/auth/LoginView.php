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
                    <input name="username" type="text" requiredd class="input-field outline-green" placeholder="ชื่อผู้ใข้งาน" required />
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                        <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                        <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
                    </svg>
                </div>
            </div>
            <div>
                <!-- <label class="text-gray-800 text-sm mb-2 block">รหัสผ่าน</label> -->
                <div class="relative flex items-center">
                    <input name="password" id="password" type="password" requiredd class="input-field outline-green password" placeholder="รหัสผ่าน" required minlength="10" />
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4 cursor-pointer" id="togglePassword" viewBox="0 0 128 128" onclick="togglePasswordVisibility()">
                        <path id="eye-icon" d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-green-600 focus:ring-green-500 border-gray-300 rounded" />
                    <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                        จดจำฉันไว้
                    </label>
                </div>

                <div class="text-sm">
                    <button type="button" class="text-primary underline hover:underline font-semibold" id="forgot-password-btn">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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