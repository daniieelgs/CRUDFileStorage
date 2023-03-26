<?php

namespace App\Classes;

class XmlFile extends FileIO implements iFileType{

    private $encoding;

    function __construct($fileName, $disk, $encoding = ''){
        parent::__construct("$fileName.xml", $disk);
        $this->encoding = $encoding;

        $this->createIfNotExist();

    }

    function createIfNotExist(){
        if($this->isMiss()){
            $this->saveData("$this->encoding<data></data>");
        }
    }

    function readAs(){
        return SimpleXML::XMLToArray($this->readData(), $this->encoding);
    }

    function saveAs($data){

        $this->createIfNotExist();

        $data = ["{tagArray}" => $data];

        $save = $this->readAs();

        if(is_array($save["data"])){
            $save["data"] += $data;
        }
        else $save["data"] = $data;

        $this->saveData(SimpleXML::arrayToXML($save, ["tagArray" => "user"], null, $this->encoding));

    }

    function update($data, $id){
        $xmlObj = $this->readAs();

        $idXml = $this->findIdArray($xmlObj, $id);

        $xmlObj["data"][$idXml] = $data;

        $this->saveData(SimpleXML::arrayToXML($xmlObj, ["tagArray" => "user"], null, $this->encoding));
    }

    private function findIdArray($xmlObj, $nif){
        $idXml = 0;

        foreach($xmlObj["data"] as $key => $value){

            if($xmlObj["data"][$key]["nif"] == $nif){
                $idXml = $key;
                break;
            }
    
        }

        return $idXml;
    }

    function delete($id){

        $xmlObj = $this->readAs();

        $idXml = $this->findIdArray($xmlObj, $id);

        unset($xmlObj["data"][$idXml]);

        $this->saveData(SimpleXML::arrayToXML($xmlObj, ["tagArray" => "user"], null, $this->encoding));

    }

    function readPlainFormated(){

        $xml = str_replace('&nbsp;', ' ', trim(preg_replace('/\s\s+/', '', $this->readData())));
        $xml = trim(preg_replace('~[\r\n]+~', '', $xml));

        $xmlFormated = "";

        $tab = 0;

        $count = 0;

        $newLine = "\r\n";

        $tabList = [];
        $openTabList = [];

        $slash = false;
        $lastOpenTag = 0;

        for($i = 0; $i < strlen($xml); $i++){

            $c = $xml[$i];

            if($c == '/'){
                $slash = true;
            }else if($c == '<' && ($i + 1 < strlen($xml) && $xml[$i + 1] == '/')){
                $lastOpenTag = $i;
                
                $found = false;
                $key = "";
                foreach($openTabList as $tag){

                    $key = substr($xml, $i + 2, strlen($tag) + 1);

                    if(substr($key, 0, -1) == $tag && substr($key, -1) == '>'){
                        $found = true;
                        break;
                    }
                }

                if($found){
                    $tab = array_pop($tabList) - 4;

                    array_push($tabList, $tab);

                    $tab = $tabList[count($tabList) - 1] - 5;

                    $c = str_repeat(" ", $tab).$c."";  
                }

                
            }else if($c == '<'){
                $lastOpenTag = $i;

                $c = str_repeat(" ", $tab).$c;
            }if($c == '>' && (($i - 1) > 0 && ($xml[$i-1] == '?' || $xml[$i-1] == ']'))){
                $count = 0;
                $c .= $newLine;
            }else if(($c == '>' && $slash)){

                $count = 0;

                $key = substr($xml, $lastOpenTag+2, $i - $lastOpenTag - 2);

                if(in_array($key, $openTabList)){

                    $tab = array_pop($tabList) - 4;

                    array_pop($openTabList);

                    $tab = array_pop($tabList);

                    array_push($tabList, $tab);

                }

                $c .= $newLine;
                $slash = false;


            }else if($c == '>'){

                $key = substr($xml, $lastOpenTag+1, $i - $lastOpenTag - 1);

                $value = substr($xml, $i+1, strpos($xml, "</$key>") - 1);

                if(SimpleXML::isXML($value)){

                    $tab += ($count + 4);
                    $count = 0;
                    $c .= $newLine;
                    array_push($tabList, $tab);
                    array_push($openTabList, $key);

                }

            }else{
                $count++;
            }

            $xmlFormated .= $c;

        }

        return $xmlFormated;

    }




}

?>