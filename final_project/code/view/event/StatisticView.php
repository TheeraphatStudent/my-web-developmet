<?php
require_once('components/tags.php');
require_once('components/breadcrumb.php');
require_once('utils/useDateTime.php');

use FinalProject\Components\Breadcrumb;
use FinalProject\Components\Tags;

function fetchEventStatistics($eventId)
{
    return [
        'totalParticipants' => 250,
        'joinedDates' => [
            '2024-03-01' => 50,
            '2024-03-02' => 75,
            '2024-03-03' => 65,
            '2024-03-04' => 60,
        ],
        'regStatus' => [
            'accepted' => 0,
            'pending' => 0,
            'reject' => 0
        ],
        'attStatus' => [
            'accepted' => 0,
            'pending' => 0,
            'reject' => 0
        ]
    ];
}

$eventId = $_GET['id'] ?? null;
$statistics = fetchEventStatistics($eventId);

$navigate = new Breadcrumb();
$navigate->setPath(
    data: ['Dashboard', 'ภาพรวมกิจกรรม', $eventId ?? "???"],
    prevPath: '?action=event.manage'
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Statistics Dashboard</title>

    <link rel="stylesheet" href="public/style/main.css">
</head>

<body class="flex flex-col justify-start items-center bg-primary">
    <div class="flex flex-col w-full gap-14 max-w-content py-[200px] px-10 xl:px-0">
        <?php $navigate->render(); ?>

        <div class="flex flex-col gap-5 w-full max-w-[1200px] mx-auto">
            <div class="w-full bg-white shadow-md rounded-lg p-6 min-h-fit flex flex-col">
                <h2 class="text-xl font-semibold text-black mb-4">จำนวนผู้เข้าร่วมงาน</h2>
                <div class="flex">
                    <canvas id="joinedChart" class="w-full h-1/2"></canvas>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-5">
                <div class="w-full bg-white shadow-md rounded-lg p-6 min-h-fit flex flex-col">
                    <h2 class="text-xl font-semibold text-black mb-4">คำขอเข้าร่วม</h2>
                    <div class="flex">
                        <canvas id="regStatusChart" class="w-full h-1/2"></canvas>
                    </div>
                </div>

                <div class="w-full bg-white shadow-md rounded-lg p-6 min-h-fit flex flex-col">
                    <h2 class="text-xl font-semibold text-black mb-4">ลงทะเบียนเข้าร่วม</h2>
                    <div class="flex">
                        <canvas id="attendanceStatusChart" class="w-full h-1/2"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.1.0/dist/chartjs-plugin-datalabels.min.js"></script>

    <script>
        const joined = <?= json_encode($statistics['joinedDates']) ?>;
        const regStatus = <?= json_encode($statistics['regStatus']) ?>;
        const attStatus = <?= json_encode($statistics['attStatus']) ?>;

        function createChart(
            chartType,
            canvasId,
            data,
            options = {},
            title = {
                x: '',
                y: ''
            }
        ) {
            const chartContext = document.getElementById(canvasId).getContext('2d');

            const defaultConfigs = {
                line: {
                    type: 'line',
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: title.y
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: title.x
                                }
                            }
                        },
                    }
                },
                pie: {
                    type: 'pie',
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = Object.values(data.datasets[0].data).reduce((a, b) => a + b, 0);
                                        const value = context.parsed;
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${context.label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#104B48',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: function(value, context) {
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${value} - (${percentage}%)`;
                                }
                            }
                        }
                    },
                },
                bar: {
                    type: 'bar',
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            };

            const chartConfig = {
                type: defaultConfigs[chartType].type,
                data: data,
                options: {
                    ...defaultConfigs[chartType].options,
                    ...options
                },
                plugins: [ChartDataLabels]
            };

            if (chartType === 'pie') {
                if (!data.datasets[0].backgroundColor) {
                    data.datasets[0].backgroundColor = [
                        '#BCFFAB',
                        '#FFE9BE',
                        '#FFC9C9'
                    ];
                }
            }

            return new Chart(chartContext, chartConfig);
        }

        createChart(
            'line',
            'joinedChart', {
                labels: Object.keys(joined),
                datasets: [{
                    label: 'จำนวนผู้เข้าร่วมงาน',
                    data: Object.values(joined),
                    borderColor: '#0053BA',
                    tension: 0.1,
                    fill: true,
                    backgroundColor: '#ABCDF755',
                }]
            }, {},
            {
                x: 'ช่วงวันที่จัดงาน',
                y: 'จำนวนผู้เข้าร่วม'
            });

        createChart('pie', 'regStatusChart', {
            labels: Object.keys(regStatus),
            datasets: [{
                data: Object.values(regStatus)
            }]
        });

        createChart('pie', 'attendanceStatusChart', {
            labels: Object.keys(attStatus),
            datasets: [{
                data: Object.values(attStatus)
            }]
        });
    </script>
</body>

</html>