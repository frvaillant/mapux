require('leaflet/dist/leaflet')

export class MapBuilder {

    constructor(container) {
        this.map = null
        this.centerLatitude = container.dataset.lat
        this.centerLongitude = container.dataset.lon
        this.zoomLevel = container.dataset.zoom
        this.mapId = container.getAttribute('id')
        this.background = container.dataset.background
        this.markers = JSON.parse(container.dataset.markers)
    }

    createMap() {
        this.map = L.map(this.mapId).setView([this.centerLatitude, this.centerLongitude], this.zoomLevel)
        this.addLayer()
        
        for(const key in this.markers) {
            this.addMarker(this.markers[key].lat, this.markers[key].lon)
        }
    }

    addLayer() {
        L.tileLayer(this.background, {}).addTo(this.map);
    }

    addMarker(lat, lon) {
        L.marker([lat, lon]).addTo(this.map)
    }

}
