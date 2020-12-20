<?php


namespace MapUx;


class Installer
{

    public static function installLeaflet()
    {
        shell_exec('npm install leaflet');
    }

}
