<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../component.php');

class Map extends Component
{
    // Location
    private $lon = null;
    private $lat = null;

    public function __construct() {}

    public function render()
    {
        echo ('
        <div id="map" class="flex w-full h-[350px] rounded-2xl relative"></div>
        <textarea required id="location_display" class="w-full min-h-[128px] mt-4 p-2 bg-gray-100 rounded" placeholder="Map detail..."></textarea>
        <input type="text" name="location" id="location_input" class="hidden">
        ');
        $this->renderScript();
    }

    public function setDefaultLocation($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    private function renderScript()
    { ?>

        <script type="text/javascript" src="https://api.longdo.com/map3/?key=<?php echo $_SESSION['mapApiKey'] ?>"></script>
        <script type="module">
            import {
                Init
            } from './components/map/map.js';

            const getLocation = async (lat, lon) => {
                const res = await fetch('../?action=request&on=map&form=get_location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        lat,
                        lon
                    })
                }).then((res) => {
                    return res.json();
                })

                return res;
            }

            document.addEventListener('DOMContentLoaded', () => {
                const init = new Init(<?= json_encode($this->lat) ?>, <?= json_encode($this->lon) ?>);

                const locationDisplay = document.getElementById('location_display');
                const locationInput = document.getElementById('location_input');

                const updateLocationDisplay = async (lat, lon) => {
                    if (!lat || !lon) return;

                    try {
                        const response = await getLocation(lat, lon);
                        // console.log(response);

                        const locationData = JSON.parse(response?.data);
                        locationDisplay.value = `${locationData?.aoi ?? 'N/A'}, ${locationData?.subdistrict ?? 'N/A'}, ${locationData?.district ?? 'N/A'}, ${locationData?.province ?? 'N/A'}, ${locationData?.postcode ?? 'N/A'}`;
                    } catch (error) {
                        console.error('Error fetching location data:', error);
                        locationDisplay.value = 'Location information unavailable';
                    }
                };

                const lat = <?= json_encode($this->lat) ?>;
                const lon = <?= json_encode($this->lon) ?>;

                if (lat && lon) {
                    updateLocationDisplay(lat, lon);
                    locationInput.value = `lat=${lat}&lon=${lon}`;
                }

                document.addEventListener('locationChanged', (event) => {
                    const {
                        lat,
                        lon
                    } = event.detail;

                    locationInput.value = `lat=${lat}&lon=${lon}`;
                    updateLocationDisplay(lat, lon);
                });
            });
        </script>
<?php }
}

class MapView extends Component
{
    public function render() {}
    public function setLocation() {}
}
