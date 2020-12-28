# MapUx

## Description
MapUx is an UX component for Symfony project. Il aims helping you to add maps in your project.  
It adds all what you need for maps, markers, popups ...  
It uses Leaflet Library wich complete documentation can be found here :  
https://leafletjs.com/reference-1.7.1.html 

## Requirements
PHP >7.2  
Symfony project >4.4  
Webpack Encore  

## Install MapUx
- `composer require frvaillant/mapux dev-master`
- `npm install --force` ou `yarn install --force`
- `php bin/console mapux:install`

## Manual Installation
If you don't want to run the mapux:install command provided by MapUx, you need to add a few lines inside your project :  

- add in your assets/app.js file:  
```javascript
require ('../vendor/frvaillant/mapux/Resources/assets/js/map.js')
```

- Create a public/bundle/mapux directory

- copy leaflet/dist/images to the directory created before :  
```shell script
cp - a node_modules/leaflet/dist/images public/bundle/mapux
```

## Quick basic example
Controller side
```php
use MapUx\Builder\MapBuilder;
use MapUx\Model\Marker;
use MapUx\Model\Popup;
  
  // [...]
  
$mapBuilder = new MapBuilder();
$map = $mapBuilder->createMap(44.00, -0.57, 10);
$marker = new Marker(44.00, -0.57);
$popup = new Popup('My popup text');
$markerClickFunction = 'alert("your click event has been triggered");';
$marker->addEvent('click', $markerClickFunction);
$marker->addPopup($popup);
$map->addMarker($marker);

return $this->render('home/index.html.twig', [
    'map' => $map,
]);
```

template side
```twig
{% extends 'base.html.twig' %}

{% block title %}Map Test{% endblock %}

{% block body %}
    {{ render_map('mymap', map) }}
{% endblock %}
```

## Use

### In your controller
#### Create a map
```php
use MapUx\Builder\MapBuilder;
$mapBuilder = new MapBuilder();
$map = $mapBuilder->createMap(44.00, -0.57, 10);
```

You can change default background with  
```php
$map->setBackground('http://{s}.tile.stamen.com/toner-lite/{z}/{x}/{y}.png');
```
You can find a list of available backgrounds here : https://www.creazo.fr/listing-des-fonds-de-cartes-dopen-street-map/  

You can of course use all leaflet available options with the setOptions() method.  
Doc : https://leafletjs.com/reference-1.7.1.html#map-example  
For example :    
```php
$map->setOptions([
    'zoomControl' => false
]);
```

#### Adding markers
```php
use MapUx\Model\Marker;
$marker = new Marker(44.00, -0.57);
```
If you need some leaflet options for markers  
Doc : https://leafletjs.com/reference-1.7.1.html#marker  
```php
$marker->setOptions(array $options);
```
and then  
```php
$map->addMarker($marker);
```
This will add a default marker on your map. 

#### Icons
If you want to personalize icons, you can create a picture for it and create a new Icon  
```php
use MapUx\Model\Icon;
$icon = new Icon();
$icon->setIconUrl('url-to-your-picture');
$marker->setIcon($icon);
```

You can also set the icon by setting it in marker options :  
```php
$icon = new Icon();
$icon->setIconUrl('url-to-your-picture');
$marker->setOptions([
    'icon' => $icon, 
]);
```
You can also set size, shadow ... and all parameters for leaflet icon.  
Doc : https://leafletjs.com/reference-1.7.1.html#icon  


#### Popup
You can also add a popup on your marker  
```php
use MapUx\Model\Popup;
$popup = new Popup('All the html you want in your popup'); 
// Or you can do like this ://  
$popup = new Popup();
$popup->setContent('All the html you need in your popup');   
```

Options for Leaflet Popup are also available with  
Doc : https://leafletjs.com/reference-1.7.1.html#popup  
```php
 $popup->setOptions([
    'minWidth' => 500
]);
```

Then bind your popup to marker with   
```php
$marker->addPopup($popup);
```

#### render map
Finally send your map in your twig render method
```php
 return $this->render('your-template.html.twig', [
    'map' => $map,
];
```

### Adding Events
You can add events on your map or markers.
Each event must be setted by its name and a javascript function as a string.

********************************************************************
**Make sure to add " ; " at the end of each javascript instruction**   
********************************************************************

For example you can add a marker by clicking on the map :

```php
$clickMapAction = '
    L.marker([event.latlng.lat, event.latlng.lng], {icon: defaultIcon}).addTo(event.target);
 ';
$map->addEvent('click', $clickMapAction);
```

You can add as much as events you need according to leaflet events

To add an event on a marker, use the same method as above.  
 For example :
```php
$dragEndAction = '
    fetch("/myroute", {  
        method: "GET"  
    }).then(response => { 
        return response.text() 
    }).then(text => {  
        console.log(text);
    });'
;

$clickAction = 'console.log(event); alert("clicked")';

$marker->addEvent('dragend', $dragEndAction);
$marker->addEvent('click', $clickAction);
```

### In your twig template

```twig
{{ render_map('your-map-id', map) }}
```

this will generate a map in a div with id="your-map-id" and class="ux-map".  
MapUx comes with the minimum CSS to set min height (150px) and width (100%) for this div.
