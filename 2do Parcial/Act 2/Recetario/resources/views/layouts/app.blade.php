<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Recetario')</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f4f5f7; margin: 0; color: #1f2937; }
        nav { background: #1e293b; color: white; padding: .75rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: white; text-decoration: none; margin-right: 1rem; font-size: .95rem; }
        nav a:hover { text-decoration: underline; }
        .contenedor { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        h1 { margin-top: 0; }
        .exito { background: #d1fae5; color: #065f46; padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .error-global { background: #fee2e2; color: #991b1b; padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .btn { background: #2563eb; color: white; padding: .5rem 1rem; border-radius: 6px; text-decoration: none; display: inline-block; border: none; cursor: pointer; font-size: .9rem; }
        .btn:hover { background: #1d4ed8; }
        .btn-sec { background: #6b7280; }
        .btn-danger { background: #dc2626; }
        .btn-sm { padding: .25rem .5rem; font-size: .8rem; }
        .tarjeta { background: white; border-radius: 8px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
        .etiqueta { display: inline-block; font-size: .7rem; padding: .15rem .5rem; border-radius: 999px; margin-right: .25rem; }
        .cat { background: #dbeafe; color: #1e40af; }
        .tiempo { background: #fef3c7; color: #92400e; }
        .dif { background: #ede9fe; color: #5b21b6; }
        label { display: block; margin-top: 1rem; font-weight: 600; font-size: .9rem; }
        input, select, textarea { width: 100%; padding: .5rem; border: 1px solid #d1d5db; border-radius: 6px; margin-top: .25rem; font-family: inherit; }
        textarea { min-height: 120px; font-family: monospace; font-size: .9rem; }
        .error { color: #dc2626; font-size: .85rem; margin-top: .25rem; }
        .acciones { display: flex; gap: .5rem; margin-top: 1rem; flex-wrap: wrap; }
        .filtros { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.5rem; align-items: center; }
        .filtros input[type="text"] { flex: 1; min-width: 180px; margin-top: 0; }
        .filtros select, .filtros button, .filtros a { margin-top: 0; }
    </style>
</head>
<body>

<nav>
    <div>
        <strong>Recetario</strong>
    </div>
    <div>
        @auth
            <a href="{{ route('recipes.index') }}">Mis recetas</a>
            <a href="{{ route('recipes.create') }}">Nueva</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" style="background:none;border:none;color:white;cursor:pointer;font-size:.95rem;">
                    Salir ({{ auth()->user()->name }})
                </button>
            </form>
        @else
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        @endauth
    </div>
</nav>

<div class="contenedor">
    @if (session('exito'))
        <div class="exito">{{ session('exito') }}</div>
    @endif

    @if ($errors->any() && !$errors->hasBag('default') === false)
        {{-- errores se muestran junto al campo --}}
    @endif

    @yield('contenido')
</div>

</body>
</html>