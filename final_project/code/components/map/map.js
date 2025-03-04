var location = { lat: 16.245587564752867, lon: 103.25024513607679 };

class Init {
    constructor(lat, lon) {
        console.log("Init Work!")
        console.log(`Lat: ${typeof lat} | ${lat}`)
        console.log(`Lon: ${typeof lon} | ${lon}`)

        var map = new longdo.Map({
            placeholder: document.getElementById('map'),
            language: 'th',
            zoom: 15,
            location: {
                lon: location.lon,
                lat: location.lat
                // lon: lon ?? location.lon,
                // lat: lat ?? location.lat
                // lon: lon,
                // lat: lat
            }
            // marker: {
            //     lon: lon ?? location.lon,
            //     lat: lat ?? location.lat
            // }
            // lastView: true
        });

        // ==========================

        // var marker = new longdo.Marker(
        //     { lon: lon, lat: lat },
        //     { weight: longdo.OverlayWeight.Top }
        // );

        // map.Overlays.add(marker);

        // ==========================

        // Map V3
        // map.Ui.DPad.visible(false);
        // map.Ui.Terrain.visible(false);
        // map.Ui.LayerSelector.visible(false);
        // map.Renderer.boxZoom.disable();
        // map.Ui.LayerSelector.visible(false);

        // Map V1
        // map.Ui.DPad.visible(false);
        // map.Ui.Mouse.enableInertia(false);

        // map.Event.bind(longdo.EventName.Ready, function () {
        //     map.Event.bind('beforeResize', function () {
                
        //     });
        // });

        map.Event.bind('click', function (pointer) {
            console.group("================ Clicked on map ================");
            console.log(pointer)

            map.Overlays.clear();

            var mouseLocation = map.location(longdo.LocationMode.Pointer);

            let lat = mouseLocation.lat;
            let lon = mouseLocation.lon;

            location = { lat: lat, lon: lon };

            // console.log(location.lat);
            // console.log(location.lon);
            // console.log(`Lat: ${lat} | Lon: ${lon} `);

            var target = new longdo.Marker({ lon: lon, lat: lat }, {
                // draggable: true,
                weight: longdo.OverlayWeight.Top,
            });

            console.log(target);

            console.groupEnd();

            // https://api.longdo.com/map/services/address?lon=[lon]&lat=[lat]&noelevation=1&key=[API]

            map.Overlays.drop(target);
            map.Overlays.add(target);

            const event = new CustomEvent('locationChanged', { detail: { lat, lon } });
            document.dispatchEvent(event);
        });
    }

}

export { Init };