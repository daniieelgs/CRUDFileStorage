@extends('layout.form')

@section('title')
    Formulari
@endsection

@section('titleForm')
    Formulari
@endsection

@section('form')
active
@endsection

@section('actionForm')"form" @endsection
@section('methodForm')"post" @endsection

@section('contentForm')

    @csrf

    <div class="col-md-6 form-floating">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Jordi" value="{{ old('name') }}">
        <label for="name">Nom</label>
        <div class="invalid-feedback">
            Camp obligatori.
        </div>
    </div>
    <div class="col-md-6 form-floating">
        <input type="text" class="form-control @error('backname') is-invalid @enderror" id="backname" name="backname" placeholder="Jordano" value="{{ old('backname') }}">
        <label for="backname">Cognom</label>
        <div class="invalid-feedback">
            Camp obligatori.
        </div>
    </div>
    <div class="col-12 form-floating">
        <input type="text" class="form-control @error('nif') is-invalid @enderror" id="nif" name="nif" placeholder="12345678Z" value="{{ old('nif') }}">
        <label for="backname">NIF</label>
        <div class="invalid-feedback">
            @if($errors->has('nif'))
                    {{$errors->first('nif')}}
            @else
                Camp obligatori.
            @endif     
        </div>
    </div>
    <div class="col-md-6">
        <label for="sex" class="form-label">Sexe</label>
        <select class="form-select @error('sex') is-invalid @enderror" name="sex" id="sex" data-selected="{{ old('sex') }}">
            <option selected>--Escogeix una opció--</option>
            <option value="0">Home</option>
            <option value="1">Done</option>
            <option value="2">Hamster</option>
            <option value="3">No Binari</option>
            <option value="4">Trienari</option>
        </select>

        <div class="invalid-feedback">
            Selecciona una opció.
        </div>
    </div>
    <div class="col-md-6">
        <label for="state" class="form-label">Estat civil</label>
        <select class="form-select @error('state') is-invalid @enderror" name="state" id="state" data-selected="{{ old('state') }}">
            <option selected>--Escogeix una opció--</option>
            <option value="0">Casat</option>
            <option value="1">Divorciat</option>
            <option value="2">Viude</option>
            <option value="3">Solter</option>
            <option value="4">Follador vividor</option>
        </select>

        <div class="invalid-feedback">
            Selecciona una opció.
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
@endsection
