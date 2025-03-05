<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');

class Search extends Component
{
    public function render()
    {
?>
        <form
            action="../?action=request&on=event&form=search"
            method="post"
            class="bg-secondary flex flex-col items-center lg:flex-row p-4 rounded-lg shadow-lg gap-5 w-full">
            <div class="flex flex-col w-full h-fit lg:flex-row gap-5">
                <!-- Field -->
                <div class="flex flex-col justify-start items-start gap-2.5 h-fit w-full">
                    กำลังมองหา
                    <input type="text" placeholder="เลือกอีเวทน์" id="looking" name="looking"
                        class="font-kanit text-base w-full h-10 input-field whitespace-nowrap text-black text-opacity-100 leading-none font-normal">
                    </input>
                </div>

                <!-- Field -->
                <!-- <div class="flex flex-col justify-start items-start gap-2.5 h-fit w-full">
                    สถาณที่
                    <input type="text" placeholder="เลือกสถานที่" name="location"
                        class="font-kanit text-base min-w-[290px] whitespace-nowrap text-black text-opacity-100 leading-none font-normal">
                    </input>
                </div> -->

                <!-- Field -->
                <div class="flex flex-col justify-start items-start gap-2.5 h-fit w-full">
                    ช่วงเวลา
                    <div class="flex gap-5">
                        <input type="datetime-local" placeholder="เลือกช่วงเวลา" name="dateStarted"
                            class="font-kanit text-base w-full max-w-[215px] h-10 input-field whitespace-nowrap text-black text-opacity-100 leading-none font-normal">
                        </input>
                        <input type="datetime-local" placeholder="เลือกช่วงเวลา" name="dateEnded"
                            class="font-kanit text-base w-full max-w-[215px] h-10 input-field whitespace-nowrap text-black text-opacity-100 leading-none font-normal">
                        </input>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <button
                type="submit"
                class="flex flex-row justify-center items-center gap-2.5 p-2.5 rounded w-full lg:w-[60px] h-full lg:h-[60px] bg-black hover:bg-black/80 active:bg-black/70">
                <div
                    class="flex justify-center items-center rounded-2xl w-7 h-7 overflow-hidden">
                    <img
                        width="24px"
                        height="24px"
                        src="../../public/icons/search.svg"
                        alt="search" />
                </div>
            </button>
        </form>
    <?php

    }
}

class Filter extends Component
{
    public function render()
    {
    ?>
        <div class="w-full flex justify-between *:font-kanit">
            <div>
                <span class="text-4xl font-bold text-white">อีเวนท์</span>
                <span class="text-4xl font-bold text-dark-secondary">ล่าสุด</span>
            </div>
            <div class="flex gap-5">
                <select id="date-select">
                    <option value="day">วันนี้</option>
                    <option selected value="week">สัปดาห์นี้</option>
                    <option value="month">เดือนนี้</option>
                </select>
                <select id="type-select">
                    <option value="any">ทั้งหมด</option>
                    <option value="online">ออนไลน์</option>
                    <option value="onsite">ออนไซต์</option>
                </select>
            </div>

        </div>
<?php

    }
}
