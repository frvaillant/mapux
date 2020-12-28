import {MapBuilder} from "./MapBuilder";
require ('../../../../../../node_modules/leaflet/dist/leaflet.css')
import '../css/map.css'

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementsByClassName('ux-map').length > 0) {
        document.getElementsByClassName('ux-map').forEach(mapZone => {
            const map = new MapBuilder(mapZone);
            map.createMap()
        })
    }
})
