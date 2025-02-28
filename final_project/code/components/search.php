<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/component.php');

class Search extends Component
{
    public function render()
    {
?>
        <form
            action="#"
            class="bg-secondary flex flex-col lg:flex-row p-6 rounded-lg shadow-lg gap-5">
            <div class="flex flex-col lg:flex-row gap-5">
                <!-- Field -->
                <div class="flex flex-col justify-start items-start gap-2.5 h-[70px] w-full">
                    <div
                        class="font-kanit text-base min-w-[290px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                        กำลังมองหา
                    </div>
                    <div
                        class="flex justify-between items-center pr-2.5 pl-2.5 gap-48 rounded border-orange-50 border-t border-b border-l border-r border-solid border w-full lg:w-72 h-9 bg-orange-50">
                        <div
                            class="font-kanit text-xs min-w-[57px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                            เลือกอีเวทน์
                        </div>
                        <div class="flex flex-col justify-center items-center w-6 h-6">
                            <img
                                width="14px"
                                height="8px"
                                src="../../public/icons/drop.svg"
                                alt="drop" />
                        </div>
                    </div>
                </div>

                <!-- Field -->
                <div class="flex flex-col justify-start items-start gap-2.5 h-[70px] w-full">
                    <div
                        class="font-kanit text-base min-w-[290px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                        สถาณที่
                    </div>
                    <div
                        class="flex justify-between items-center pr-2.5 pl-2.5 gap-[152px] rounded w-full lg:w-72 h-9 bg-orange-50">
                        <div
                            class="font-kanit text-xs min-w-[98px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                            เลือกสถาณที่จัดงาน
                        </div>
                        <div
                            class="flex flex-col justify-center items-center rounded-[80px] h-5 overflow-hidden">
                            <img
                                width="20px"
                                height="18.5px"
                                src="../../public/icons/map.svg"
                                alt="map" />
                        </div>
                    </div>
                </div>

                <!-- Field -->
                <div class="flex flex-col justify-start items-start gap-2.5 h-[70px] w-full">
                    <div
                        class="font-kanit text-base min-w-[290px] whitespace-nowrap text-orange-50 text-opacity-100 leading-none font-normal">
                        ช่วงเวลา
                    </div>
                    <div
                        class="flex justify-between items-center pr-2.5 pl-2.5 gap-44 rounded border-orange-50 border-t border-b border-l border-r border-solid border w-full lg:w-72 h-9 bg-orange-50">
                        <div
                            class="font-kanit text-xs min-w-[67px] whitespace-nowrap text-neutral-400 text-opacity-100 leading-none font-normal">
                            เลือกช่วงเวลา
                        </div>
                        <img
                            width="24px"
                            height="24px"
                            src="../../public/icons/date.svg"
                            alt="date" />
                    </div>
                </div>
            </div>

            <!-- Search -->
            <button
                type="submit"
                class="flex flex-row justify-center items-center gap-2.5 p-2.5 rounded w-[70px] h-[70px] bg-neutral-800">
                <div
                    class="flex justify-center items-center rounded-[80px] w-7 h-7 overflow-hidden">
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
                    <option value="onsite">อนนไซต์</option>
                </select>
            </div>

        </div>
<?php

    }
}
