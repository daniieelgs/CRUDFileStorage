<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;


class FileIO{

    private $file;
    private $disk;

    function __construct($file, $disk){
        $this->file = $file;
        $this->disk  = $disk;
    }

    public function download(){
        if(Storage::disk($this->disk)->exists($this->file)){
            return Storage::disk($this->disk)->download($this->file);
        }else{
            return 'File not found';
        }
    }

    public function saveData($data){
        Storage::disk($this->disk)->put($this->file, $data);
    }

    function readData(){
        return Storage::disk($this->disk)->get($this->file);
    }

    function getURL(){
        return $this->disk == 'public' ? Storage::url($this->file) : null;
    }

    function isMiss(){
        return Storage::disk($this->disk)->missing($this->file);
    }
}

?>