<?php

namespace FinalProject\Components;

use FinalProject\Components\NotLoggedIn;

require_once('component.php');
require_once('alert.php');

class Navbar extends Component
{
    private $isLogin = false;
    private $isProfileVerify = false;

    public function render()
    {
?>
        <nav class="fixed top-0 bg-white w-screen z-50 shadow-md shadow-primary/40" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-[.75rem]">
                    <div class="flex items-center">
                        <a href="../" class="text-white font-bold text-xl">
                            <img src="public/images/logo.png" alt="act gate" width="70px" height="70px">
                        </a>
                    </div>

                    <div class="md:block hidden">
                        <div class="flex h-full gap-4 items-baseline *:text-black">
                            <?php if ($this->isLogin) : ?>
                                <a href='../?action=event.create' class='nav-item hover:text-gray-600 text-sm rounded-md font-medium'>สร้างกิจกรรม</a>
                                <a href='../?action=event.manage' class='nav-item hover:text-gray-600 text-sm rounded-md font-medium'>จัดการกิจกรรม</a>
                                <a href='../?action=mail' class='nav-item hover:text-gray-600 text-sm rounded-md font-medium'>ประวัติการเข้าร่วม</a>
                                <div class="flex gap-2 items-center border-l-2 border-dark-primary">
                                    <a href="../?action=profile" class="ml-4 hover:text-gray-600 text-sm font-medium flex items-center no-underline">
                                        <div class="w-[56px] h-[56px] flex items-center justify-center rounded-full bg-primary text-white text-xl font-bold">
                                            <?= htmlspecialchars(strtoupper(substr($_SESSION['user']['username'], 0, 1))) ?>
                                        </div>
                                    </a>
                                </div>
                            <?php else : ?>
                                <a href='..?action=register' class='group btn-primary signin-btn w-[160px]'>
                                    <span class='group-hover:text-white'>สร้างบัญชี</span>
                                </a>
                                <a href='..?action=login' class='group btn-primary-outline login-btn'>
                                    <span class='group-hover:text-white'>เข้าสู่ระบบ</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="md:hidden block">
                        <button id="menuToggleBtn" class="flex items-center font-semibold h-14 px-4 rounded-xl transition-opacity ">
                            <img src="public/icons/drawer.png" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div id="mobileMenu" class="fixed inset-0 bg-white w-screen h-fit p-5 pt-[8rem] hidden">
            <div class="flex flex-col h-full items-center gap-4 *:text-black">
                <?php if ($this->isLogin) : ?>
                    <div class="flex gap-2 items-center">
                        <a href="../?action=profile" class="ml-4 hover:text-gray-600 text-sm font-medium flex items-center no-underline">
                            <div class="w-[56px] h-[56px] flex items-center justify-center rounded-full bg-primary text-white text-xl font-bold">
                                <?= htmlspecialchars(strtoupper(substr($_SESSION['user']['username'], 0, 1))) ?>
                            </div>
                        </a>
                    </div>
                    <a href='../?action=event.create' class='nav-item hover:text-gray-600 text-sm rounded-md font-medium'>สร้างกิจกรรม</a>
                    <a href='../?action=event.manage' class='nav-item hover:text-gray-600 text-sm rounded-md font-medium'>จัดการกิจกรรม</a>
                    <a href='../?action=mail' class='nav-item hover:text-gray-600 text-sm rounded-md font-medium'>ประวัติการเข้าร่วม</a>
                <?php else : ?>
                    <a href='..?action=register' class='group btn-primary signin-btn w-[160px]'>
                        <span class='group-hover:text-white'>สร้างบัญชี</span>
                    </a>
                    <a href='..?action=login' class='group btn-primary-outline login-btn w-[160px]'>
                        <span class='group-hover:text-white'>เข้าสู่ระบบ</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const menuToggleBtn = document.getElementById("menuToggleBtn");
                const mobileMenu = document.getElementById("mobileMenu");

                menuToggleBtn.addEventListener("click", function() {
                    mobileMenu.classList.toggle("hidden");
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isVerify = <?php echo $this->isProfileVerify ?>;
                const navItems = document.querySelectorAll('.nav-item');

                navItems.forEach((item) => {
                    item.addEventListener('click', function(event) {
                        if (!isVerify) {
                            event.preventDefault();
                            Swal.fire({
                                title: 'ยังขาดข้อมูลส่วนตัวบางส่วน!',
                                text: 'กรุณาใส่ข้อมูลส่วนตัวที่โปรไฟล์ก่อนดำเนินการต่อ',
                                icon: 'error',
                                showDenyButton: true,
                                confirmButtonText: 'ไปที่โปรไฟล์',
                                denyButtonText: 'ยังก่อน'
                            }).then((action) => {
                                if (action.isConfirmed) {
                                    window.location.href = '../?action=profile&isEdit=true'

                                }

                            });
                        }
                    });
                });
            });
        </script>
<?php
    }

    public function updateNavbar(bool $isLogin, $isProfileVerify)
    {
        $this->isLogin = $isLogin;
        $this->isProfileVerify = $isProfileVerify;
    }
}
