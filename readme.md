# MapUx
![logo](http://frvaillant.com/mapux/logo.svg)
## Description
MapUx is an UX component for Symfony project. Its goal is to help you to add maps in your project directly from your controllers.  
It adds all what you need for maps, markers, popups ...  
It uses Leaflet Library wich complete documentation can be found here :  
https://leafletjs.com/reference-1.7.1.html 

> Please note that this version of mapUX is still in development.  
> We are building this component with love and care but some errors can be found.
> Tests are on the way and Some functions will soon be added (polygons for example)  
> Please use github issues to report any problem encountered.  
> Have fun.

## Requirements
> PHP >7.2  
> Symfony project >4.4  
> composer  
> Webpack Encore  

## Install MapUx
- `composer require frvaillant/mapux dev-master`
- `npm install --force` or `yarn install --force`
- `php bin/console mapux:install`

## Manual Installation
If you don't want to run the mapux:install command provided by MapUx, you need to add a few things into your project :  

- first run these two necessary commands :  
    - `composer require frvaillant/mapux dev-master`
    - `npm install --force` ou `yarn install --force`

*********** Instructions below are done by `php bin/console mapux:install` command ***********  

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
- Controller side
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

- template side
```twig
{% extends 'base.html.twig' %}

{% block title %}Map Test{% endblock %}

{% block body %}
    {{ render_map('mymap', map) }}
{% endblock %}
```

## How to use ?

### In your controller
#### Creating a map
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

You can also add a complete set of markers :  
```shell script
$marker = new Marker(44.00, -0.57);
$marker2 = new Marker(44.10, -0.58);
$marker3 = new Marker(44.20, -0.59);
$map->setMarkers([$marker, $marker1, $marker2]);
```

#### Icons
If you want to personalize icons, you can create a picture for it and create a new Icon  
```php
use MapUx\Model\Icon;
$icon = new Icon();
$icon->setIconPicture('url-to-your-picture');
$marker->setIcon($icon);
```

You can also set the icon by setting it in marker options :  
```php
$icon = new Icon();
$icon->setIconPicture('url-to-your-picture');
$marker->setOptions([
    'icon' => $icon, 
]);
```
You can of course set size, shadow ... and all parameters for leaflet icon.  
Doc : https://leafletjs.com/reference-1.7.1.html#icon  


#### Popup
You can add a popup on your marker  
```php
use MapUx\Model\Popup;
$popup = new Popup('<p>All the html you want in your popup</p>'); 
// Or you can do like this ://  
$popup = new Popup();
$popup->setContent('<span>All the html you need in your popup</span>');   
```

Options for Leaflet Popup are also available with  
```php
 $popup->setOptions([
    'minWidth' => 500
]);
```
Doc : https://leafletjs.com/reference-1.7.1.html#popup  


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
Each event must be set by its name, a javascript function and optionally some parameters.

MapUx gives your two ways to add events on your map or markers.

#### Use MapuxEvents class
If you ran `php bin/console mapux:install`, a MapuxEvents.js file has been added in your assets/js directory.  
This class can help you to add more complex events.  
**Do not change the constructor**  

To add an event, add a method in this file. The below example shows you how to add a marker by clicking on the map.  
```javascript
export class MapuxEvents {
    constructor(target, map, defaultIcon) {
        this.target = target // Should be the map or a marker
        this.map = map
        this.defaultIcon = defaultIcon
    }

    addIcon(event, params) { 
// the event variable embed the leaflet event you used
// params are optionnal and will be defined in php as an array
     const marker = L.marker([event.latlng.lat, event.latlng.lng], {
                icon : this.defaultIcon // Do not forget this or define a method to set your icon
            }).addTo(this.map)
            marker.on('click', (e) => {
                console.log(params['word'])
            })
    }
}
```

In your controller :  
```php
$map->addEvent('click', 'addIcon', [
    'word' => 'the word to show in alert window'
]);
```

You can set multiple events using setEvents method :  
```php
$map->setEvents([
            'eventName' => [ 
                'methodName', 
                [ 
                    'param1' => 'param1Value',
                    'param2' => 'param2Value' 
                ] 
            ],
            'eventName2' => [ 
                'methodName', 
                null 
            ]
        ]);
```

#### Add javascript function as string
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

Add an event on a marker with the same method as above.  
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

and you can also add multiple events with :
```php
$marker->setEvents([
    'dragend' => [$dragEndAction, null],
    'click'   => [$clickAction, null]
]);
```

### Finally in your twig template

```twig
{{ render_map('your-map-id', map) }}
```
By default the div is rendered with a class named "ux-map"
You can add as much class as you need for your map by adding a classlist as last parameter :
```twig
{{ render_map('your-map-id', map, 'my-class-1 my-class-2') }}
```

this will generate a map in a div with id="your-map-id".  
MapUx comes with the minimum CSS to set min height (400px) and width (100%) for this div.

**MapUx development is still in process. Use carefully and please contact me about each problem you encounter. Have fun**
