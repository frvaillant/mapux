<?php


namespace MapUx;
use Composer\Script\Event;

class Installer
{

    public static function installLeaflet(Event $event)
    {
        shell_exec('npm install leaflet');
    }

}
