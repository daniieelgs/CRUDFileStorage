<?php

namespace App\Classes;


class JsonFile extends FileIO implements iFileType{

    function __construct($fileName, $disk){
        parent::__construct("$fileName.json", $disk);

        $this->createIfNotExist();

    }

    function createIfNotExist(){
        if($this->isMiss()){
            $this->saveData('{"data":[]}');
        }
    }

    function readAs(){
        return json_decode($this->readData());
    }

    function saveAs($data){

        $this->createIfNotExist();

        $save = $this->readAs();

        array_push($save->data, $data);

        $this->saveData(json_encode($save));

    }

    function update($data, $id){
        $jsonObj = $this->readAs();
        $idJson = $this->findIdArray($jsonObj, $id);

        $jsonObj->data[$idJson] = $data;

        $this->saveData(json_encode($jsonObj));
    }

    function delete($id){

        $jsonObj = $this->readAs();
        $idJson = $this->findIdArray($jsonObj, $id);

        unset($jsonObj->data[$idJson]);

        $jsonObj->data = array_values($jsonObj->data);

        $this->saveData(json_encode($jsonObj));

    }

    private function findIdArray($jsonObj, $nif){
        $idJson = 0;

        foreach($jsonObj->data as $key => $value){

            if($jsonObj->data[$key]->nif == $nif){
                $idJson = $key;
                break;
            }
    
        }

        return $idJson;
    }

    function readPlainFormated(){

        $json = trim(preg_replace('/\s\s+/', '', $this->readData()));

        $tab = 0;

        $count = 0;

        $jsonFormated = "";

        $newLine = "\r\n";

        $tabList = [];

        for($i = 0; $i < strlen($json); $i++){

            $c = $json[$i];

            if($c == ']' || $c == '}' || (($i + 1) < strlen($json) && $json[$i + 1] == ',' && ($c == '}' || $c == ']'))){

                $tab = array_pop($tabList) - 4;

                $count = 0;
                
                $c = $newLine.($tab > 0 ? str_repeat(" ", $tab) : "").$c;

               $tab = array_pop($tabList);

               array_push($tabList, $tab);

            }else if($c == '{' || $c == '['){

                $tab += (4 + $count);

                $count = 0;

                array_push($tabList, $tab);

                $c .= $newLine.($tab > 0 ? str_repeat(" ", $tab) : "");

            }else if($c == ','){
                $count = 0;
                $c .= $newLine.($tab > 0 ? str_repeat(" ", $tab) : "");
            }else{
                $count++;
            }

            $jsonFormated .= $c;

        }

        return $jsonFormated;

    }




}

?>