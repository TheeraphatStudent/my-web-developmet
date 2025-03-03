<?php

namespace FinalProject\View;

require_once(__DIR__ . '/../../components/calendar/calendar.php');

use FinalProject\Components\SchedulerCalendar;

$calendar = new SchedulerCalendar();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/style/main.css">
    <title>Profile</title>
</head>

<body class="bg-primary w-screen h-fit flex flex-col justify-start items-center pt-[120px] mb-[160px] px-5 lg:px-16 gap-12 overflow-x-hidden">
    <div class="inline-flex flex-col justify-center w-full h-fit max-w-content gap-4">
        <div class="flex w-full justify-between items-center">
            <span class="text-2xl md:text-4xl font-semibold font-kanit text-white text-overflow">Profile</span>
            <div>
                <button type="button" class="underline decoration-red text-white hover:text-red/60 md:btn-danger md:w-40">Logout</button>
            </div>
        </div>

        <div class="flex flex-col bg-white/40 w-full h-fit min-h-fit rounded-xl p-8 gap-8">
            <div class="flex flex-col items-center md:flex-row gap-6">
                <div class="flex justify-center items-center w-32 h-32 min-w-[128px] min-h-[128px] relative border-4 border-white rounded-full overflow-hidden">
                    <img class="object-cover object-center w-full h-full" src='https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ' alt='Woman looking front'>
                </div>

                <div class="flex flex-col justify-center w-full gap-3 overflow-hidden">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <span class="text-xl md:text-3xl font-semibold font-kanit text-dark-secondary text-overflow"><?= $_SESSION['user']['username'] ?></span>
                        <div>
                            <button type="button" class="text-base md:underline decoration-secondary text-white hover:text-secondary/60 md:btn-secondary md:w-40" id="editProfileBtn">Edit</button>
                        </div>
                    </div>
                    <!-- <span class="font-kanit font-light text-lg md:text-xl text-black text-overflow"><?= $_SESSION['user']['userId'] ?></span> -->
                    <div class="flex w-full gap-4 mt-2 *:bg-dark-primary/40">
                        <div class="flex flex-col w-full rounded-lg py-2 px-4 text-center">
                            <span class="text-sm text-white">อีเวนท์ที่สร้าง</span>
                            <p class="text-xl font-bold text-white">12</p>
                        </div>
                        <div class="flex flex-col w-full rounded-lg py-2 px-4 text-center">
                            <span class="text-sm text-white">อีเวนท์ที่เข้าร่วม</span>
                            <p class="text-xl font-bold text-white">5</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="border-t border-black/10 pt-6">
                <h3 class="text-xl md:text-2xl font-semibold font-kanit text-secondary/80 mb-4">ข้อมูลส่วนตัว</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">Full Name</span>
                        <span class="font-medium">Theeraphat Chueanokkhum</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">Gender</span>
                        <span class="font-medium">Male</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">Birthday</span>
                        <span class="font-medium">January 15, 1995</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">Telephone</span>
                        <span class="font-medium">+66 89 123 4567</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">Education</span>
                        <span class="font-medium">Bachelor of Engineering, AGU University</span>
                    </div>
                </div>
            </div>

            <!-- Membership Info -->
            <div class="border-t border-black/10 pt-6">
                <h3 class="text-xl md:text-2xl font-semibold font-kanit text-secondary/80 mb-4">สมาชิก</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">เข้าร่วมเมื่อ</span>
                        <span class="font-medium">March 2023</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="font-medium flex items-center">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editProfileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold font-kanit text-dark-secondary">แก้ไขข้อมูลส่วนตัว</h3>
                <button type="button" id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editProfileForm" class="space-y-6" action="#">
                <!-- Profile Picture Section -->
                <div class="flex flex-col items-center gap-3">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white relative group">
                        <img id="previewImage" class="object-cover w-full h-full" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ" alt="Profile picture">
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <label for="profileImage" class="text-white cursor-pointer text-sm">
                                เปลี่ยนรูป
                            </label>
                        </div>
                    </div>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*" class="hidden">
                </div>

                <!-- Personal Information Fields -->
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="fullName" class="text-sm font-medium text-gray-700">ชื่อ-นามสกุล</label>
                            <input type="text" id="fullName" name="fullName" class="w-full rounded-lg border border-gray-300 px-3 py-2" value="Theeraphat Chueanokkhum">
                        </div>

                        <div class="space-y-2">
                            <label for="gender" class="text-sm font-medium text-gray-700">เพศ</label>
                            <select id="gender" name="gender" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                                <option value="male" selected>ชาย</option>
                                <option value="female">หญิง</option>
                                <option value="other">อื่นๆ</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="birthday" class="text-sm font-medium text-gray-700">วันเกิด</label>
                            <input type="date" id="birthday" name="birthday" class="w-full rounded-lg border border-gray-300 px-3 py-2" value="1995-01-15">
                        </div>

                        <div class="space-y-2">
                            <label for="telephone" class="text-sm font-medium text-gray-700">เบอร์โทรศัพท์</label>
                            <input type="tel" id="telephone" name="telephone" class="w-full rounded-lg border border-gray-300 px-3 py-2" value="+66 89 123 4567">
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="education" class="text-sm font-medium text-gray-700">การศึกษา</label>
                            <input type="text" id="education" name="education" class="w-full rounded-lg border border-gray-300 px-3 py-2" value="Bachelor of Engineering, AGU University">
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancelEditBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">ยกเลิก</button>
                    <button type="submit" id="confirmEditBtn" class="px-4 py-2 bg-dark-secondary text-white rounded-lg hover:bg-secondary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>

    <!-- <div style="display: flex;gap: 10;justify-content: center;flex-direction: row;">
        <div class="flex flex-row md:flex-col gap-10 bg-white/40 w-20 h-28 min-h-fit rounded-xl p-8">
            <h1>Num of join Event : </h1>
        </div>
        <div class="flex flex-row md:flex-col gap-10 bg-white/40 w-20 h-28 min-h-fit rounded-xl p-8">
            <h1>Num of create Event : </h1>
        </div>
    </div> -->

    <div class="inline-flex flex-col w-full h-fit max-w-content gap-10">
        <div class="flex w-full justify-between">
            <span class="text-2xl md:text-4xl font-semibold font-kanit text-white text-overflow">อีเวนท์เดือนนี้</span>
        </div>

        <?php
        $calendar->render();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editProfileBtn');

            const modal = document.getElementById('editProfileModal');
            const closeModalBtn = document.getElementById('closeModalBtn');

            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const editProfileForm = document.getElementById('editProfileForm');

            const profileImageInput = document.getElementById('profileImage');
            const previewImage = document.getElementById('previewImage');

            editBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });

            function closeModal() {
                modal.classList.add('hidden');
            }

            closeModalBtn.addEventListener('click', closeModal);

            cancelEditBtn.addEventListener('click', function() {
                closeModal();
            });

            editProfileForm.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'ยืนยันการแก้ไขข้อมูล?',
                    text: 'ข้อมูลของคุณจะถูกอัปเดต',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'บันทึกข้อมูล',
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(editProfileForm.value);
                        editProfileForm.submit();

                        closeModal();
                        Swal.fire(
                            'บันทึกเรียบร้อย!',
                            'ข้อมูลของคุณถูกอัปเดตแล้ว',
                            'success'
                        );
                    }
                });
            });

            profileImageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>