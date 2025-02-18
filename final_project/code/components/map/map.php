<?php

namespace FinalProject\Components;

require_once(__DIR__ . '/../component.php');

class Map extends Component
{
    private $mapApiKey;

    // Location
    private $lon;
    private $lat;

    public function __construct($mapApiKey)
    {
        $this->mapApiKey = $mapApiKey;
    }

    public function render()
    {
        echo ('
    <div id="map" class="flex w-full h-[350px] rounded-2xl relative"></div>
        <div id="location" class="mt-4 p-2 bg-gray-100 rounded"></div>');
        $this->renderScript();
    }

    private function renderScript()
    {
?>
        <script type="text/javascript" src="https://api.longdo.com/map3/?key=<?php echo ($this->mapApiKey); ?>"></script>
        <script type="module">
            import {
                Init
            } from '/code/components/map/map.js';

            document.addEventListener('DOMContentLoaded', () => {
                const init = new Init();

                const location = document.getElementById('location');

                document.addEventListener('locationChanged', (event) => {
                    const {
                        lat,
                        lon
                    } = event.detail;
                    console.log(`${lat} | ${lon}`);
                    location.textContent = `${lat}, ${lon}`;
                });
            });
        </script>
<?php

    }
}
