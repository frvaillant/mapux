import {MapBuilder} from "./MapBuilder";
require('leaflet/dist/leaflet.css')
import '../css/map.css'
require('../images/marker-icon.png')
require('../images/marker-shadow.png')
require('../images/red-icon.png')
require('../images/green-icon.png')
require('../images/orange-icon.png')
require('../images/yellow-icon.png')
require('../images/pink-icon.png')
require('../images/purple-icon.png')
require('../images/brown-icon.png')
require('../images/black-icon.png')

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


