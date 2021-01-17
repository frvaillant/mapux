import {MapBuilder} from "./MapBuilder";
require ('leaflet/dist/leaflet.css')
import '../css/map.css'

if ("complete" === document.readyState || "interactive" === document.readyState) {
    if (document.getElementsByClassName('mapux-map').length > 0) {
        document.getElementsByClassName('mapux-map').forEach(mapZone => {
            const mapBuilder = new MapBuilder(mapZone);
            mapBuilder.createMap()
        })
    }
} else {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementsByClassName('mapux-map').length > 0) {
            document.getElementsByClassName('mapux-map').forEach(mapZone => {
                const mapBuilder = new MapBuilder(mapZone);
                mapBuilder.createMap()
            })
        }
    })
}


