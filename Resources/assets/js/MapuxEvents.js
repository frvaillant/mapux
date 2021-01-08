require ('../../../node_modules/leaflet/dist/leaflet')

export class MapuxEvents {
    constructor(target, map, icons) {
        this.target = target // Should be the map or a marker
        this.map = map
        this.icons = icons
    }
}
