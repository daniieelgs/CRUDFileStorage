@extends('layout.form')

@section('title')
    Editar
@endsection

@section('titleForm')
    Editar
@endsection

@section('edit')
active
@endsection

@section('actionForm')"edit" @endsection
@section('methodForm')"post" @endsection

@section('contentPreForm')
    <form id="formDelete" action="delete" method="get"></form>

    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar usuari</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Está segur de que desitja eliminar aquest usuari?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" id="btnDeleteUser" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script src="js/validate_form.js"></script>

    <script src="js/load_edit_form.js"></script>

    <script>
        document.querySelector('.needs-own-validation').addEventListener('submit', validateForm)
    </script>

@endsection

@section('contentForm')

    @csrf

    <div class="mb-3" style="width: 100%">
        <label for="user" class="form-label">Usuari</label>
        <select class="form-select @error('user') is-invalid @enderror" name="user" id="user" data-selected="{{ old('user') }}" style="text-align: center">
            <option selected>--Escogeix un usuari--</option>
        </select>

        <div class="invalid-feedback">
            Selecciona una opció.
        </div>
    </div>

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
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">
            Eliminar
        </button>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
@endsection
