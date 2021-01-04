require ('../../node_modules/leaflet/dist/leaflet')

export class MapuxEvents {
    constructor(target, map, defaultIcon) {
        this.target = target // Should be the map or a marker
        this.map = map
        this.defaultIcon = defaultIcon
    }

    test(event, params) {
        alert(params['word']);
    }
}
