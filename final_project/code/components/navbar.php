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
        <nav class="absolute top-0 bg-white w-screen ">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-[.75rem]">
                    <div class="flex items-center">
                        <a href="index.php" class="text-white font-bold text-xl">
                            <img src="../../public/images/logo.png" alt="act gate" srcset="" width="70px" height="70px">
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
                            <a href='#' class='group flex items-center font-semibold h-14 bg-none border-[.15rem] text-primary border-primary px-6 rounded-xl hover:bg-primary transition-colors duration-300'>
                                <span class='group-hover:text-white'>Sign In</span>
                            </a>
                            <a href='#' class='group flex items-center font-semibold h-14 bg-none border-[.15rem] text-primary border-primary px-6 rounded-xl hover:bg-primary transition-colors duration-300'>
                                <span class='group-hover:text-white'>Log In</span>
                            </a>
                            ";
                            ?>

                        </div>
                    </div>
                    <div class="md:hidden block">
                        <div class="flex items-baseline space-x-4">
                            <a href='#' class='flex items-center font-semibold h-14 px-4 rounded-xl'>
                                <img src="../../public/icons/drawer.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
<?php
    }
}
