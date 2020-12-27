# MapUx

## Description
MapUx is an UX component for Symfony project. Il aims helping you to add maps in your project.  
It adds all what you nedd for maps, markers, popups ...  
It uses Leaflet Library wich works with open street map 

## Requirements
PHP >7.2  
Symfony project >4.4  
Webpack Encore  

## Install MapUx
- `composer require frvaillant/mapux dev-master`
- `npm install --force`
- `php bin/console mapux:install`

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

You can of course use all leaflet available options with  
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
You can also set size, shadow ... and all parameters for leaflet icon.  

#### Popup
You can also add a popup on your marker  
```php
use MapUx\Model\Popup;
$popup = new Popup('All the html you wand in your popup'); 
// Or you can do like this ://  
$popup = new Popup();
$popup->setContent('All the html you nedd in your popup');   
```

Options for Leaflet Popup are also available with  
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

### In your twig template

```twig
{{ render_map('your-map-id', map) }}
```

this will generate a map in a div with id="your-map-id" and class="map-ux".  
MapUx comes with the minimu CSS to set min height (150px) and width (100%) for this div.
