<?php

namespace App\Http\Controllers;

use App\Classes\FileIO;
use App\Classes\JsonFile;
use App\Classes\SelectOptions;
use App\Classes\SimpleXML;
use App\Classes\XmlFile;
use App\Http\Requests\OwnRequest as RequestsOwnRequest;
use App\Http\Requests\OwnRequestEdit as RequestsOwnRequestEdit;

class FormController extends Controller
{
    
    private $file = "dataUser";
    private $diskJSON = "local";
    private $diskXML = "public";
    private $encoding = '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE data [<!ENTITY nbsp "entity-value">]>';

    function download($disk, $file){

        $fileControl = new FileIO($file, $disk);
        return $fileControl->download();

    }

    function edit(){
        return view('edit');
    }

    function delete($nif){

        $xmlFile = new XmlFile($this->file, $this->diskXML, $this->encoding);
        $jsonFile = new JsonFile($this->file, $this->diskJSON);

        if(count(array_filter($jsonFile->readAs()->data, fn($n) => $n->nif == $nif)) == 0) return abort(404);

        $jsonFile->delete($nif);
        $xmlFile->delete($nif);

        return view('recap', ["dataJSON" => $jsonFile->readPlainFormated(), "dataXML" => $xmlFile->readPlainFormated()]);

    }

    function editUser(RequestsOwnRequestEdit $req){

        $req->request->remove("_token");
        $req->merge(['sexName' => SelectOptions::$SEX_VALUES[$req->input('sex')], 'stateName' => SelectOptions::$STATE_VALUES[$req->input('state')]]);

        $xmlFile = new XmlFile($this->file, $this->diskXML, $this->encoding);
        $jsonFile = new JsonFile($this->file, $this->diskJSON);

        $user = $req->input('user');

        $req->request->remove("user");

        $jsonFile->update($req->all(), $user);
        $xmlFile->update($req->all(), $user);

        return view('recap', ["dataJSON" => $jsonFile->readPlainFormated(), "dataXML" => $xmlFile->readPlainFormated()]);
    }

    function index(){
        return view('index');
    }

    function getData(){
        return response()->json((new JsonFile($this->file, $this->diskJSON))->readAs(), 200, array(), 0);
    }

    function saveForm(RequestsOwnRequest $req){

        $req->request->remove("_token");
        $req->merge(['nif' => strtoupper($req->input('nif')),'sexName' => SelectOptions::$SEX_VALUES[$req->input('sex')], 'stateName' => SelectOptions::$STATE_VALUES[$req->input('state')]]);

        $xmlFile = new XmlFile($this->file, $this->diskXML, $this->encoding);
        $jsonFile = new JsonFile($this->file, $this->diskJSON);

        $xmlFile->saveAs($req->all());
        $jsonFile->saveAs($req->all());

        return view('recap', ["dataJSON" => $jsonFile->readPlainFormated(), "dataXML" => $xmlFile->readPlainFormated()]);

    }

    function recap(){

        $json = new JsonFile($this->file, $this->diskJSON);
        $xml = new XmlFile($this->file, $this->diskXML, $this->encoding);
        
        return view('recap', ["dataJSON" => $json->readPlainFormated(), "dataXML" => $xml->readPlainFormated()]);

    }

    function loadJSON(){

        $json = new JsonFile($this->file, $this->diskJSON);

        return view('viewer', ["data" => $json->readPlainFormated(), "object" => $json->readAs(), "type" => "JSON", "download" => "download/$this->diskJSON/$this->file.json"]);
    }

    function loadXML(){

        $xml = new XmlFile($this->file, $this->diskXML, $this->encoding);

        return view('viewer', ["data" => $xml->readPlainFormated(), "object" => $xml->readAs(), "type" => "XML", "download" => "download/$this->diskXML/$this->file.xml", "open" => $xml->getURL()]);
    }
}
