<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 27/09/16
 * Time: 17:34
 */

namespace AppBundle\Utils;


class Util
{
    /**
     * @param $string
     * @return mixed
     */
    static public function unaccent($string){
        $search = explode(',','á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ');
        $replace = explode(',','a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y');
        return str_replace($search, $replace, $string);
    }

}
