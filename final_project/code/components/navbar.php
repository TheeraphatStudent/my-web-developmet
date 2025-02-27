<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');

class Navbar extends Component
{
    private $isLogin = false;

    public function render()
    {
        $activeLink = $this->data['activeLink'] ?? '';
        

?>
        <nav class="fixed top-0 bg-white w-screen z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-[.75rem]">
                    <div class="flex items-center">
                        <a href="../" class="text-white font-bold text-xl">
                            <img src="public/images/logo.png" alt="act gate" srcset="" width="70px" height="70px">
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="md:block hidden">
                        <div class="flex items-baseline space-x-4">
                            <?php echo
                            $this->isLogin
                                ?
                                "
                            <a href='#' class='text-gray-800 hover:text-gray-600 px-3 py-2 rounded-md text-sm font-medium'>Profile</a>
                            " :
                                "
                            <a href='..?action=register' class='group btn-primary signin-btn w-[160px]'>
                                <span class='group-hover:text-white'>สร้างบัญชี</span>
                            </a>
                            <a href='..?action=login' class='group btn-primary-outline login-btn'>
                                <span class='group-hover:text-white'>เข้าสู่ระบบ</span>
                            </a>
                            ";
                            ?>

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

    public function updateNavbar(bool $isLogin) {
        $this->isLogin = $isLogin;

    }
}
