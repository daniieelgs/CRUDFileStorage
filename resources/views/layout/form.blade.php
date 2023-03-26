@extends('layout.master')

@section('head')
    <link href="css/form_style.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
   
    <script src="js/validate_form.js"></script>

    <script>
        document.querySelector('.needs-own-validation').addEventListener('submit', validateForm)
    </script>

@endsection


<div class="card text-center formCardCenter">
    <div class="card-header">
      @yield('titleForm')
    </div>
    <div class="card-body">

        @yield('contentPreForm')

        <form class="row g-3 needs-own-validation" novalidate id="form" action=@yield('actionForm') method=@yield('methodForm')>
            @yield('contentForm')
        </form>      
        
    </div>
</div>

@endsection

