<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAMEmprende</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .custom-navbar {
            background-color: #439FA5;
        }

        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link {
            color: white;
            padding-left: 20px;
        }

        .custom-navbar .nav-link:hover {
            color: #dddddd;
        }

        .admin-badge {
            background-color: #F47E17;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 50%;
            margin-left: 5px; /* Espacio entre la insignia y el enlace */
        }

        .admin-badge-container {
            display: flex;
            align-items: center;
            margin-left: auto; /* Empujar hacia la derecha */
            padding-right: 20px; /* Añadir espacio a la derecha */
        }

        .admin-badge-container .admin-badge {
            margin-left: 5px; /* Espacio entre la insignia y el enlace */
        }
    </style>
    <!-- Otros elementos del encabezado -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg custom-navbar">
        <a class="navbar-brand" href="/">UAMEmprende</a>
        <div class="admin-badge-container">
            @if (Auth::check() && Auth::user()->admin)
                <span class="admin-badge">ADMIN</span>
            @endif
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarme</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->nombre }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item"
                                    href="{{ route('profile.edit', Auth::user()->id) }}">Editar
                                    Cuenta</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favorites') }}">Favoritos</a>
                    </li>
                    @if (Auth::user()->admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('estudiantes') }}">Usuarios</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('misEmprendimientos') }}">Mis Emprendimientos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('crear.emprendimiento') }}">Crear Emprendimiento</a>
                        </li>
                    @endif

                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
