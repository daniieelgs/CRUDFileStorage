<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <div class="collapse navbar-collapse" id="navbarNav" style="width: 100%">
            <ul class="nav nav-tabs justify-content-center" style="width: 100%">
                <li class="nav-item">
                  <a class="nav-link @yield('form')" aria-current="page" href="/">Form</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @yield('JSON')" href="/seeJSON">JSON File</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @yield('XML')" href="/seeXML">XML File</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @yield('recap')" href="/recap">Recap</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @yield('edit')" href="/edit">Edit</a>
                </li>
                @yield('links')
            </ul>
          </div>
        </div>
    </nav>

    <div id="mainContent">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>