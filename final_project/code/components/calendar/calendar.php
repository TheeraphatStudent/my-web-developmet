<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../component.php');

class SchedulerCalendar extends Component
{
    public function render()
    {

?>
        <link rel="stylesheet" href="public/style/main.css">
        <div class="">
            <div id="app" class="container mx-auto max-w-content">
                <div class="flex lg:flex-row flex-col  gap-4">
                    <!-- Calendar Section -->
                    <div class="bg-white/40 rounded-lg shadow-lg p-6 flex-1">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-secondary" id="currentMonth"></h1>
                            <div class="space-x-2">
                                <button id="prevMonth" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Previous</button>
                                <button id="nextMonth" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Next</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-2 mb-2">
                            <div class="text-center font-semibold">Sun</div>
                            <div class="text-center font-semibold">Mon</div>
                            <div class="text-center font-semibold">Tue</div>
                            <div class="text-center font-semibold">Wed</div>
                            <div class="text-center font-semibold">Thu</div>
                            <div class="text-center font-semibold">Fri</div>
                            <div class="text-center font-semibold">Sat</div>
                        </div>

                        <div id="calendar" class="grid grid-cols-7 gap-2 min-h-fit h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh] max-h-[500px]"></div>
                    </div>

                    <!-- Events Side Panel -->
                    <div class="bg-white/40 rounded-lg shadow-lg p-6 w-full lg:max-w-[350px]">
                        <h2 class="text-xl font-bold mb-4 text-secondary">รายการ</h2>
                        <div id="monthEvents" class="h-full min-h-[310px] max-h-[620px] overflow-y-auto space-y-4 pr-5"></div>
                    </div>
                </div>

                <!-- Event Details Modal -->
                <div id="eventDetailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-full max-w-md">
                        <h2 class="text-xl font-bold mb-4" id="detailsTitle"></h2>
                        <p class="text-gray-600 mb-4" id="detailsDescription"></p>
                        <div class="flex justify-end space-x-2">
                            <button id="moreDetails"></button>
                            <button id="closeDetailsModal"></button>
                        </div>
                    </div>
                </div>
            </div>
            <script type="module" src="./components/calendar/calendar.js"></script>
        </div>
<?php

    }
}
