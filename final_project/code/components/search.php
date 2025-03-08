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
                        class="input-field">
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
                            class="input-field">
                        </input>
                        <input type="datetime-local" placeholder="เลือกช่วงเวลา" name="dateEnded"
                            class="input-field">
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
        <style>
            @keyframes glow {
                0% {
                    filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.5));
                }

                50% {
                    filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.8));
                }

                100% {
                    filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.5));
                }
            }

            @keyframes glow2 {
                0% {
                    filter: drop-shadow(0 0 2px rgba(0, 83, 186, 0.5));
                }

                50% {
                    filter: drop-shadow(0 0 10px rgba(171, 205, 255, 0.5));
                }

                100% {
                    filter: drop-shadow(0 0 2px rgba(0, 83, 186, 0.5));
                }
            }

            .glow-word {
                font-family: sans-serif;
                font-weight: bold;
                font-size: 48px;
                fill: white;
                animation: fadeIn 1s ease-out forwards, glow 3s infinite;
            }

            .glow2-word {
                font-family: sans-serif;
                font-weight: bold;
                font-size: 48px;
                fill: white;
                animation: fadeIn 1s ease-out forwards, glow2 2s infinite;
            }
        </style>

        <div class="w-full flex justify-between mb-4 *:font-kanit">
            <div class="cursor-pointer" onclick="window.location.reload()">
                <span class="text-4xl font-bold text-white glow-word">อีเวนท์</span>
                <span class="text-4xl font-bold text-dark-secondary glow2-word">ล่าสุด</span>
            </div>
            <form
                action="../?action=request&on=event&form=search_categories"
                method="post"
                class="flex gap-5">
                <!-- <select class="input-field" id="date-select" name="date" onchange="this.form.submit()">
                    <option value="day">วันนี้</option>
                    <option selected value="week">สัปดาห์นี้</option>
                    <option value="month">เดือนนี้</option>
                </select> -->
                <?php
                $selectedType = $_SESSION['selected_type'] ?? '';
                ?>
                <select class="input-field" id="type-select" name="type" onchange="this.form.submit()">
                    <option value="" <?php echo $selectedType == '' ? 'selected' : ''; ?>>เลือกกิจกรรม</option>
                    <option value="any" <?php echo $selectedType == 'any' ? 'selected' : ''; ?>>ทั้งหมด</option>
                    <option value="online" <?php echo $selectedType == 'online' ? 'selected' : ''; ?>>ออนไลน์</option>
                    <option value="onsite" <?php echo $selectedType == 'onsite' ? 'selected' : ''; ?>>ออนไซต์</option>
                </select>

            </form>

        </div>
<?php

    }
}
