import {MapBuilder} from "./MapBuilder";
require ('../../../../../../node_modules/leaflet/dist/leaflet.css')
import '../css/map.css'

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementsByClassName('mapux-map').length > 0) {
        document.getElementsByClassName('mapux-map').forEach(mapZone => {
            const mapBuilder = new MapBuilder(mapZone);
            mapBuilder.createMap()
        })
    }
})
