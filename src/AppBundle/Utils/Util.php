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

    /**
     * @return array
     */
    static public function alphaRange(){
        $counts = array_fill(0,28,0);
        $values = array();
        foreach( $counts as $key=>$val ) {
            $values[$key]['selected'] = 0;
            $values[$key]['count'] = $val;
            $values[$key]['list'] = array();
        }
        $keys = range('A','Z');
        array_unshift($keys, '#');
        array_unshift($keys, '*');
        $result = array_combine($keys,$values);
        return $result;
    }

    static public function adsyncAlphaRange() {
        $results['person-no-id'] = self::alphaRange();
        $results['person-wrong-id'] = self::alphaRange();
        $results['person-correct-id'] = self::alphaRange();
        return $results;
    }

    /**
     * @return array The list of options for the active/nonactive/all list of possible entries
     *               for people list on ADSync screen
     */
    public function getActiveOptions() {
        $activeOptions = array(
            'active' => 'adsync.active.options.active',
            'inactive' => 'adsync.active.options.nonactive',
            'all' => 'adsync.active.options.all',
        );
        return $activeOptions;
    }

}
