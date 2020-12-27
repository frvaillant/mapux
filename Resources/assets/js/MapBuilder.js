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
        this.options = JSON.parse(container.dataset.options)

        this.defaultIcon = L.icon({
            iconUrl: '/build/images/marker-icon.png',
            shadowUrl: '/build/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize: [41, 41]
        });

    }

    createMap() {
        this.map = L.map(this.mapId, this.options).setView([this.centerLatitude, this.centerLongitude], this.zoomLevel)
        this.addLayer()

        for(const key in this.markers) {
            this.addMarker(this.markers[key].lat, this.markers[key].lon, this.markers[key].icon)
        }
    }

    addLayer() {
        L.tileLayer(this.background, {}).addTo(this.map);
    }

    addMarker(lat, lon, icon = null) {
        if (null === icon) {
            L.marker([lat, lon], {icon: this.defaultIcon}).addTo(this.map)
        } else {
            const dataIcon = JSON.parse(icon)
            const Icon = L.icon({
                iconUrl: dataIcon.iconUrl,
                shadowUrl: dataIcon.shadowUrl,
                iconSize: dataIcon.iconSize,
                iconAnchor: dataIcon.iconAnchor,
                popupAnchor: dataIcon.popupAnchor,
                tooltipAnchor: dataIcon.tooltipAnchor,
                shadowSize: dataIcon.shadowSize
            })
            L.marker([lat, lon], {icon: Icon}).addTo(this.map)
        }
    }

}
