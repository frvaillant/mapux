export class GridGenerator {

    constructor(options) {
        this.options = options
        this.rectangles = []
        this.startLat = this.options.startLat
        this.startLon = this.options.startLon
        this.endLat   = this.options.endLat
        this.endLon   = this.options.endLon
    }

    getNextLat(lat0, lon0) {
        return parseFloat(lat0) + (180/Math.PI)*(this.options.unit/6378137)
    }

    getNextLon(lat0, lon0) {
        return parseFloat(lon0) + (180/Math.PI)*(this.options.unit/6378137*1.4)
    }

    createRectangle(lat0, lon0, lat1, lon1) {
        return L.rectangle([[lat0, lon0], [lat1, lon1]], this.options)
    }

    createGrid() {
        let limit = 0
        this.originLng = this.startLon
        let nb = 0
        while (limit === 0) {
            nb++
            const rect = this.createRectangle(this.startLat, this.startLon, this.getNextLat(this.startLat, this.startLon), this.getNextLon(this.startLat, this.startLon))

            this.rectangles.push(rect)
            this.startLon = this.getNextLon(this.startLat, this.startLon)
            if (this.startLon >= this.endLon) {
                this.startLon = this.originLng
                this.startLat = this.getNextLat(this.startLat, this.startLon)
                if (this.startLat >= this.endLat || nb === 100) {
                    limit = 1
                }
            }
        }
    }

    getRectangles() {
       return this.rectangles;
    }
}
