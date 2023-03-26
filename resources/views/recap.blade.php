@extends('layout.master')

@section('head')
    <link href="css/visualizer.css" rel="stylesheet" type="text/css">
@endsection

@section('recap')
active
@endsection

@section('content')
    <div class="viewer">
        <h1>File JSON</h1>
        @dump($dataJSON)
    </div>
    <div class="viewer">
        <h1>File XML</h1>
        @dump($dataXML)
    </div>
@endsection