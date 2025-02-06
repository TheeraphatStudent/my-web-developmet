var map;
var location = { lat: 0, lon: 0 };

class Init {
    constructor() {
        console.log("Init Work!")

        map = new longdo.Map({
            placeholder: document.getElementById('map'),
            language: 'th',
            zoom: 2
        });

        // Map V3
        // map.Ui.DPad.visible(false);
        // map.Ui.Terrain.visible(false);
        // map.Ui.LayerSelector.visible(false);
        // map.Renderer.boxZoom.disable();
        // map.Ui.LayerSelector.visible(false);

        // Map V1
        // map.Ui.DPad.visible(false);
        // map.Ui.Mouse.enableInertia(false);

        map.Event.bind('click', function (pointer) {
            console.group("================ Clicked on map ================");
            console.log(pointer)

            map.Overlays.clear();

            var mouseLocation = map.location(longdo.LocationMode.Pointer);

            let lat = mouseLocation.lat;
            let lon = mouseLocation.lon;

            location = { lat: lat, lon: lon };

            console.log(location.lat);
            console.log(location.lon);
            console.log(`Lat: ${lat} | Lon: ${lon} `);

            var target = new longdo.Marker({ lon: lon, lat: lat }, {
                draggable: true,
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