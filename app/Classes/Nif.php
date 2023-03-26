<?php

namespace App\Classes;

class Nif{

    public static function isValid($nif){

        return preg_match("/\d{8}[A-Z]/i", strtoupper($nif)) && strlen($nif) == 9 && strtoupper(substr($nif, -1)) == str_split("TRWAGMYFPDXBNJZSQVHLCKE")[substr($nif, 0, 8) % 23];

    }

    public static function exists($nif, $file, $disk){

        $json = new JsonFile($file, $disk);
        return count(array_filter($json->readAs()->data, fn($n) => $n->nif == $nif)) > 0;

    }

}

?>