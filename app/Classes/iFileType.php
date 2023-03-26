<?php

namespace App\Classes;

interface iFileType{

    public function readAs();
    public function saveAs($data);
    public function readPlainFormated();
    public function createIfNotExist();
    function update($data, $id);
    function delete($id);

}

?>