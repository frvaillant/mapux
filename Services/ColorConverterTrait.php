<?php


namespace MapUx\Services;

/**
 * Trait ColorConverterTrait
 * @package MapUx\Services
 */

trait ColorConverterTrait
{

    /**
     * @param $color
     * @param null $opacity
     * @return string
     *
     * Author : Bojan Petrovic
     * Refactoring : François VAILLANT
     * https://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
     */
    protected function hex2rgba($color, $opacity = null) {

        if(empty($color)) {
            throw new \Exception('no color is provided.');
        }

        $color = ($color[0] === '#') ? substr( $color, 1 ) : $color;

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) === 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) === 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            throw new \Exception('A color have to be provided with 3 or 6 numbers');
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1) {
                $opacity = 1;
                return 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
            }
        }
        return 'rgb('.implode(",",$rgb).')';
    }

}
