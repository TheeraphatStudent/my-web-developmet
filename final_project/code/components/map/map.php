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

            // async function fetchAddress(lat, lon) {
            //     const response = await fetch(`/fetch-address.php?lat=${lat}&lon=${lon}`);
            //     return await response.json();
            // }

            document.addEventListener('DOMContentLoaded', () => {
                const init = new Init();

                const location = document.getElementById('location');

                document.addEventListener('locationChanged', async (event) => {
                    const {
                        lat,
                        lon
                    } = event.detail;
                    console.log(`${lat} | ${lon}`);

                    // const res = await fetchAddress($lat, $lon);
                    // console.log(res);

                    location.textContent = `${lat}, ${lon}`;
                });
            });
        </script>
<?php

    }

    // private function fetchAddress($lat, $lon)
    // {
    //     $url = `https://api.longdo.com/map/services/address?lon=$lon&lat=$lat&noelevation=1&key={$this->mapApiKey}`;

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    //     $response = curl_exec($ch);

    //     if (curl_errno($ch)) {
    //         error_log('Curl error: ' . curl_error($ch));
    //         return false;
    //     }

    //     curl_close($ch);

    //     return json_decode($response, true);
    // }
}

class MapSelector extends Component {
    public function render() {

    }

}