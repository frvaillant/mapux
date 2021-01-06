require('leaflet/dist/leaflet')
import { MapuxEvents } from "../../../../../../assets/js/mapux/MapuxEvents";

export class MapBuilder {

    constructor(container) {
        this.map = null
        this.centerLatitude = container.dataset.lat
        this.centerLongitude = container.dataset.lon
        this.zoomLevel = container.dataset.zoom
        this.mapEvents = container.dataset.events
        this.mapId = container.getAttribute('id')
        this.background = container.dataset.background
        this.markers = JSON.parse(container.dataset.markers)
        this.options = JSON.parse(container.dataset.options)
        this.layers  = JSON.parse(container.dataset.layers)

        this.defaultIcon = L.icon({
            iconUrl: '/bundle/mapux/images/marker-icon.png',
            shadowUrl: '/bundle/mapux/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize: [41, 41]
        });
    }

    createMap() {

        this.map = L.map(this.mapId, this.options).setView([this.centerLatitude, this.centerLongitude], this.zoomLevel)
        this.addBasemapLayer()
        this.addOptionnalLayers()

        // ADDING MAP EVENTS ///////////////////////////////////////
        if (this.mapEvents) {
            const events = JSON.parse(this.mapEvents)
            for (const key in events) {

                this.map.on(events[key].name, (event) => {
                    const defaultIcon = this.defaultIcon
                    try {
                        eval(events[key].action)
                    } catch(error) {
                        try {
                            const UxEvent = new MapuxEvents(this.map, this.map, this.defaultIcon)
                            UxEvent[events[key].action](event, events[key].params)
                        } catch (e) {
                            console.error('map event is not correctly defined' + ' : ' + e)
                        }
                    } finally {

                    }
                })
            }
        }

        // ADDING MARKERS
        if (this.markers) {
            for (const key in this.markers) {
                this.addMarker(
                    this.markers[key].lat,
                    this.markers[key].lon,
                    this.markers[key].icon,
                    this.markers[key].options,
                    this.markers[key].popup,
                    this.markers[key].events
                )
            }
        }
    }

    addBasemapLayer() {
        L.tileLayer(this.background, {}).addTo(this.map)
    }

    addOptionnalLayers() {
        if(this.layers) {

            for (const key in this.layers) {

                if (this.layers[key].isGeoJson) {
                    L.geoJSON(JSON.parse(this.layers[key].json)).addTo(this.map)
                } else {
                    L.tileLayer(this.layers[key].background, this.layers[key].options).addTo(this.map)
                }
            }
        }
    }

    makeIcon(iconData) {
        const icon = JSON.parse(iconData)
        const Icon = L.icon({
            iconUrl: icon.iconUrl,
            shadowUrl: icon.shadowUrl,
            iconSize: icon.iconSize,
            iconAnchor: icon.iconAnchor,
            popupAnchor: icon.popupAnchor,
            tooltipAnchor: icon.tooltipAnchor,
            shadowSize: icon.shadowSize
        })
        return Icon
    }

    addMarker(lat, lon, icon = null, options = null, popup = null, events = null) {

        options = (options && "null" !== options) ?  JSON.parse(options) : {}

        // SETTING ICON //////////////////////////////////////////
        if (!options.icon) {
            if (null === icon) {
                options.icon = this.defaultIcon
            } else {
                options.icon = this.makeIcon(icon)
            }
        } else {
            options.icon = this.makeIcon(options.icon)
        }

        // ADDING MARKER //////////////////////////////////////////
        const marker = L.marker([lat, lon], options).addTo(this.map)

        // ADDING POPUP ON MARKER /////////////////////////////////
        if (popup && "null" !== popup) {
            const myPopup = this.makePopup(popup)
            marker.bindPopup(myPopup)
        }

        // ADDING EVENTS ON MARKER /////////////////////////////////
        if (events && "null" !== events) {
            this.addEvents(events, marker)
        }
    }

    addEvents(events, marker) {
        events = JSON.parse(events)
        for (const key in events) {
            marker.on(events[key].name, (event) => {
                try {
                    eval(events[key].action)
                } catch(error) {
                    try {
                        const UxEvent = new MapuxEvents(this.map, this.map, this.getIcons())
                        UxEvent[events[key].action](event, events[key].params)
                    } catch (e) {
                        console.error('marker event is not correctly defined' + ' : ' + e)
                    }
                }
            })
        }
    }

    makePopup(popup) {
        const popupData = JSON.parse(popup)
        let myPopup = L.popup(popupData.options)
        myPopup.setContent(popupData.content)
        return myPopup
    }

    createIcon(color) {
        return L.icon({
            iconUrl: '/bundle/mapux/images/' + color + '-icon.png',
            shadowUrl: '/bundle/mapux/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            tooltipAnchor: [16, -28],
            shadowSize: [41, 41]
        })
    }

    getIcons() {
        return {
            "blue": this.defaultIcon,
            "red": this.createIcon('red'),
            "green": this.createIcon('green'),
            "orange": this.createIcon('orange'),
            "yellow": this.createIcon('yellow'),
            "pink": this.createIcon('pink'),
            "purple": this.createIcon('purple'),
            "brown": this.createIcon('brown'),
            "black": this.createIcon('black'),
        }
    }
}
