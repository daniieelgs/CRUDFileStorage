@extends('layout.master')

@section('head')
    <link href="css/visualizer.css" rel="stylesheet" type="text/css">
@endsection

@section($type)
active
@endsection

@section('content')
    <div class="viewer">
        <h1>Object {{$type}}</h1>
        @dump($object)
    </div>
    <div class="viewer">
        <h1>File {{$type}}</h1>
        @dump($data)
    </div>

    <div class="downloadContainer">

        <a class="buttonDownload" href="{{$download}}">Download {{$type}} File</a>

        @if (isset($open))
            <a class="buttonDownload" href="{{$open}}">Open {{$type}} File</a>
        @endif

    </div>
@endsection