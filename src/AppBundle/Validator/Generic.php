<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 28/10/16
 * Time: 14:42
 */

namespace AppBundle\Validator;

class Generic
{
    /**
     * @return array list of allowed languages
     */
    public static function getAllowedLanguages() {
        return array(
            'en',
            'nl',
            'fr',
        );
    }

    /**
     * @return array list of allowed values for International name cascade field
     */
    public static function getAllowedIntNameCascade() {
        return array(
            0,
            1,
            2,
        );
    }
}
