export class MapBuilder {

    constructor(container) {

        this.map = null
        this.centerLatitude = container.dataset.lat
        this.centerLongitude = container.dataset.lon
        this.zoomLevel = container.dataset.zoom
        this.mapId = container.getAttribute('id')
    }

    createMap() {
        alert('hop')
        this.map = L.map(this.mapId).setView([this.centerLatitude, this.centerLongitude], this.zoomLevel)
    }

}
