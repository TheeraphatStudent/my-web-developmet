<?php

namespace FinalProject\View;

echo $mapApiKey
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://api.longdo.com/map3/?key=<?php echo ($mapApiKey); ?>"></script>
    <!-- <script type="text/javascript" src="https://api.longdo.com/map3/?key=55072ff6dc986c8484ea0615c17bf149"></script> -->
    <script type="module">
        import {
            Init
        } from '../../code/script/map.js';

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

    <link rel="stylesheet" href="public/style/main.css">
</head>

<body>
    <div id="map" class="flex w-[640px] h-[350px] rounded-2xl relative"></div>
    <div id="location" class="mt-4 p-2 bg-gray-100 rounded"></div>
</body>

</html>