<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../component.php');

class Map extends Component
{
    // Location
    private $lon;
    private $lat;

    public function __construct() {}

    public function render()
    {
        echo ('
        <div id="map" class="flex w-full h-[350px] rounded-2xl relative"></div>
        <div id="location_display" class="mt-4 p-2 bg-gray-100 rounded"></div>
        <input type="text" name="location" id="location_input" class="hidden">
        ');
        $this->renderScript();
    }

    private function renderScript()
    {
?>

        <script type="text/javascript" src="https://api.longdo.com/map3/?key=<?php echo $_SESSION['mapApiKey'] ?>"></script>
        <script type="module">
            import {
                Init
            } from './components/map/map.js';

            document.addEventListener('DOMContentLoaded', () => {
                const init = new Init();
                const locationDisplay = document.getElementById('location_display');
                const locationInput = document.getElementById('location_input');

                document.addEventListener('locationChanged', async (event) => {
                    const {
                        lat,
                        lon
                    } = event.detail;
                    console.log(`${lat} | ${lon}`);
                    locationInput.value = `lat=${lat}&lon=${lon}`

                    const response = await fetch('../?action=request&on=map&form=get_location', {
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

                    console.log(JSON.parse(response?.data))

                });
            });
        </script>
<?php
    }
}

class MapSelector extends Component
{
    public function render() {}
}
