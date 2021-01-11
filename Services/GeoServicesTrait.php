<?php


namespace MapUx\Services;


trait GeoServicesTrait
{
    public function distanceBetween($lat1, $lng1, $lat2, $lng2) {
        $rad = M_PI / 180;
        return round(acos(sin($lat2*$rad) * sin($lat1*$rad) + cos($lat2*$rad) * cos($lat1*$rad) * cos($lng2*$rad - $lng1*$rad)) * 6371000, 2);
    }
}
