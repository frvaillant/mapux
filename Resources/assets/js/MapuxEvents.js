require ('leaflet/dist/leaflet')

export class MapuxEvents {
    //******************************************************
    // PLEASE DO NOT CHANGE CONSTRUCTOR ********************
    //******************************************************

    /**
     *
     * @param target : the target of the event
     * @param map : the instance of your map
     * @param icons : the available icons provided by mapux (default, red, ....)
     */
    constructor(target, map, icons) {
        this.target = target // Should be the map or a marker
        this.map = map
        this.icons = icons
    }

    /* *******************************************************
    WRITE YOUR METHODS BELOW

    addIcon(event) {
        L.marker([event.latlng.lat, event.latlng.lng], {
            icon:this.icons.red
        }).addTo(this.map)
    }
     */


}
