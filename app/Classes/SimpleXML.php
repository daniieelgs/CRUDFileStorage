<?php

namespace App\Classes;

class SimpleXML{


    public static function makeTagXML($key, $value){
        $value = str_replace(' ', '&nbsp;', $value);
        return "<$key>$value</$key>";
    }

    public static function getFirstKeyFromTag($tag){
        return substr($tag, strpos($tag, '<')+1, strpos($tag, '>')-1);
    }

    public static function getKeysFromTag($tag){

        if(!SimpleXML::isXML($tag)) return [];

        $key = substr($tag, strpos($tag, '<')+1, strpos($tag, '>')-1);

        $keys = [$key];

        $moreKeys = SimpleXML::getKeysFromTag(substr($tag, strpos($tag, "</$key>") + 3 + strlen($key)));

        if(count($moreKeys) > 0) array_push($keys, ...$moreKeys);

        return $keys;
    }


    public static function getValueFromTag($xml, $tagName, $pos = 0){

        $start = strpos($xml, "<$tagName>") + 2 + strlen($tagName);
        $end = strpos($xml, "</$tagName>");
        
        if($pos > 0) return SimpleXML::getValueFromTag(substr($xml, $end + strlen($tagName) + 2), $tagName, $pos-1);

        return str_replace('&nbsp;', ' ', substr($xml, $start, $end - $start));
    }

    public static function isXML($xml){
        return preg_match('/^<.*>.*<\/.*>/', $xml);
    }

    public static function arrayToXML($data, $variablesTag, $global_tag = null, $xml_data = '') {
        
        $xml = $xml_data;

        if($global_tag != null) $xml .= "<$global_tag>";
        
        foreach($data as $_key => $value ) {
            
            $key = $_key;

            if(array_key_exists(substr($_key, 1, -1), $variablesTag)) $key = $variablesTag[substr($_key, 1, -1)];
            else if(preg_match('/^.*\([0-9]*\)/', $_key)) $key = substr($_key, 0, strpos($_key, "("));

            $xml .= is_array($value) ? SimpleXML::arrayToXML($value, $variablesTag, $key) : SimpleXML::makeTagXML($key, $value);
         }

         if($global_tag != null) $xml .= "</$global_tag>";

         return $xml;
    }

    public static function XMLToArray($xml, $xml_data = ''){

        $xml = trim(preg_replace('~[\r\n]+~', '', trim(preg_replace('/\s\s+/', '', $xml))));

        $xml = str_replace($xml_data, '', $xml);

        $keys = SimpleXML::getKeysFromTag($xml);

        $arr = [];

        $keysRepeated = [];

        for($i = 0; $i < count($keys); $i++){

            $key = $keys[$i];       

            $count = 0;

            for($j = 0; $j < count($keys); $j++){

                if($keys[$j] == $keys[$i]){

                    if($j != $i) $count++;
                    else break;

                }

            }

            $value = SimpleXML::getValueFromTag($xml, $key, $count);

            $keyRepeated = count(array_filter($keys, fn($n) => $n == $key)) > 1;

            if($keyRepeated){

                if(!array_key_exists($key, $keysRepeated)) $keysRepeated += [$key => -1];

                $keysRepeated[$key] += 1;

            }

            $arr += [$keyRepeated ? $key."($keysRepeated[$key])" : $key => SimpleXML::isXML($value) ? SimpleXML::XMLToArray($value) : $value];
        }

        return $arr;

    }

}

?>
