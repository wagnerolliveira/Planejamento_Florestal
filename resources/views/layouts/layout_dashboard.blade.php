<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href={{ Vite::asset('resources/images/logoforestfy.png') }}/>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://kit.fontawesome.com/8fdcd3a9ac.js" crossorigin="anonymous"></script>
        <!-- Styles -->
        @vite(['resources/css/layout_dashboard.css'])
        @yield('styles')
        
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
        @vite(['resources/js/app.js'])
        @vite(['resources/js/scripts.js'])
    </head>
    <body>
        <header class="navbar sticky-top bg-dark flex-md-nowrap p-3 border">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <span class="app-brand-logo demo">
                    <img class="d-none d-md-block mx-auto" height="40" src={{ Vite::asset('resources/images/Forestfyw.png') }} alt="Forestfy">
                    <img class="d-block d-md-none mx-auto" height="40" src={{ Vite::asset('resources/images/logoW.png') }} alt="Forestfy">
                </span>
            </a> 
            <ul class="navbar-nav flex-row d-md-none">
                <li class="nav-item text-nowrap">
                    <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-list"></i>
                    </button>
                </li>
            </ul>
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="sidebar col-md-5 col-lg-2 p-2">
                    <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                        <div class="offcanvas-header">
                            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                                <span class="app-brand-logo demo">
                                    <img class="d-block d-md-block mx-auto" height="40" src={{ Vite::asset('resources/images/Forestfyg.png') }} alt="Forestfy">
                                    <img class="d-none d-md-none mx-auto" height="40" src={{ Vite::asset('resources/images/logoforestfy.png') }} alt="Forestfy">
                                </span>
                            </a>
                            <button type="button" class="btn-close"
                              data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                              aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body d-md-flex flex-column p-2 pt-lg-3 overflow-y-auto">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href={{ route('jobs') }}>
                                        <i class="bi bi-clipboard2-data-fill"></i>
                                        <span>Tarefas</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href={{ route('zones') }}>
                                        <i class="fa fa-regular fa-chart-area"></i>
                                        <span>Áreas</span>
                                    </a>
                                </li>
                                
                            </ul>
            
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('logout') }}">
                                        <i class="bi bi-door-open-fill"></i>
                                        <span>Sair</span>
                                    </a>
                                </li>
                            </ul>                   
                        </div>
                    </div>
                </div> 
            
                <main class="col-md-7 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
        @vite(['resources/js/app.js'])
        @yield('scripts') 
    </body>
</html>
    