<?php

namespace FinalProject\Components;

use FinalProject\Controller\AuthController;
use FinalProject\Controller\RequestController;
use LDAP\Result;

require_once(__DIR__ . '/component.php');

class Navbar extends Component
{
    private $isLogin = false;
    public function render()
    {
        $activeLink = $this->data['activeLink'] ?? '';


?>
        <nav class="fixed top-0 bg-white w-screen z-50" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-[.75rem]">
                    <div class="flex items-center">
                        <a href="../" class="text-white font-bold text-xl">
                            <img src="public/images/logo.png" alt="act gate" width="70px" height="70px">
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="md:block hidden">
                        <div class="flex h-full gap-4 items-baseline *:text-black">
                            <?php if ($this->isLogin) : ?>
                                <a href='../?action=event.create' class= hover:text-gray-600 rounded-md text-sm font-medium'>Create event</a>
                                <a href='../?action=event.manage' class= hover:text-gray-600 rounded-md text-sm font-medium'>Event view</a>
                                
                                <div class="border-l-2 border-dark-primary">
                                    <a href='../?action=profile' class='ml-4 hover:text-gray-600 rounded-md text-sm font-medium'>
                                        Profile
                                    </a>
                                    <a href='../?action=mail' class='ml-4 hover:text-gray-600 rounded-md text-sm font-medium'>
                                        mail
                                    </a>
                                    <a href='../?' class='ml-4 hover:text-gray-600 rounded-md text-sm font-medium'>Logout</a>
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
                        <div class="flex items-baseline space-x-4">
                            <a href='#' class='flex items-center font-semibold h-14 px-4 rounded-xl'>
                                <img src="public/icons/drawer.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
<?php
    }

    public function updateNavbar(bool $isLogin)
    {
        $this->isLogin = $isLogin;
    }
}
