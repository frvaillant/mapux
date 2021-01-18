import {MapBuilder} from "./MapBuilder";
require('leaflet/dist/leaflet.css')
import '../css/map.css'

export const reqIcons = {
    "default": require('../images/marker-icon.png'),
    "shadow": require('../images/marker-shadow.png'),
    "red": require('../images/red-icon.png'),
    "green": require('../images/green-icon.png'),
    "orange": require('../images/orange-icon.png'),
    "yellow": require('../images/yellow-icon.png'),
    "pink": require('../images/pink-icon.png'),
    "purple": require('../images/purple-icon.png'),
    "brown": require('../images/brown-icon.png'),
    "black": require('../images/black-icon.png'),
}

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


