<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800">

    <div class="max-w-7xl mx-auto p-6">

        {{-- Encabezado --}}
        <header class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Gestor de Tareas</h1>
            <a href="{{ route('task.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition">
                + Nueva tarea
            </a>
        </header>

        {{-- Mensaje de éxito --}}
        @if (session('exito'))
            <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-lg mb-6">
                {{ session('exito') }}
            </div>
        @endif

        {{-- Filtros --}}
        <form method="GET" action="{{ route('task.index') }}"
              class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-3 items-center">

            <input type="text" name="q" placeholder="Buscar por título..."
                   value="{{ $filtros['q'] ?? '' }}"
                   class="flex-1 min-w-[200px] border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <select name="estado"
                    class="border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todos los estados</option>
                @foreach ($estados as $clave => $etiqueta)
                    <option value="{{ $clave }}" @selected(($filtros['estado'] ?? '') === $clave)>{{ $etiqueta }}</option>
                @endforeach
            </select>

            <select name="prioridad"
                    class="border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Todas las prioridades</option>
                @foreach ($prioridades as $clave => $etiqueta)
                    <option value="{{ $clave }}" @selected(($filtros['prioridad'] ?? '') === $clave)>{{ $etiqueta }}</option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg transition">
                Filtrar
            </button>

            <a href="{{ route('task.index') }}"
               class="text-slate-600 hover:text-slate-900 px-3 py-2 transition">
                Limpiar
            </a>
        </form>

        {{-- Tablero --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            @foreach ($estados as $claveEstado => $etiquetaEstado)
                @php
                    $colores = [
                        'por_hacer' => ['bg' => 'bg-slate-200', 'text' => 'text-slate-700'],
                        'en_curso'  => ['bg' => 'bg-blue-100',  'text' => 'text-blue-700'],
                        'terminado' => ['bg' => 'bg-emerald-100','text' => 'text-emerald-700'],
                    ];
                    $color = $colores[$claveEstado] ?? ['bg' => 'bg-slate-200', 'text' => 'text-slate-700'];
                @endphp

                <section class="{{ $color['bg'] }} rounded-xl p-4 min-h-[300px]">

                    <h2 class="font-bold {{ $color['text'] }} uppercase text-sm tracking-wide mb-3 flex justify-between">
                        <span>{{ $etiquetaEstado }}</span>
                        <span class="bg-white text-slate-700 rounded-full px-2 text-xs">
                            {{ $tareasPorEstado->get($claveEstado)?->count() ?? 0 }}
                        </span>
                    </h2>

                    @forelse ($tareasPorEstado->get($claveEstado, collect()) as $tarea)
                        <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition p-4 mb-3">

                            <h3 class="font-semibold text-slate-900 mb-1">{{ $tarea->titulo }}</h3>

                            @if ($tarea->descripcion)
                                <p class="text-sm text-slate-600 mb-2">
                                    {{ Str::limit($tarea->descripcion, 90) }}
                                </p>
                            @endif

                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                @php
                                    $coloresPrioridad = [
                                        'baja'  => 'bg-emerald-500',
                                        'media' => 'bg-amber-500',
                                        'alta'  => 'bg-red-500',
                                    ];
                                @endphp
                                <span class="text-white text-xs px-2 py-0.5 rounded-full {{ $coloresPrioridad[$tarea->prioridad] ?? 'bg-slate-500' }}">
                                    {{ $prioridades[$tarea->prioridad] }}
                                </span>
                                <span class="text-xs text-slate-500">
                                    {{ $tarea->vencimiento->format('d/m/Y') }}
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-1">
                                <a href="{{ route('task.show', $tarea) }}"
                                   class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-1 rounded transition">
                                    Ver
                                </a>
                                <a href="{{ route('task.edit', $tarea) }}"
                                   class="text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 px-2 py-1 rounded transition">
                                    Editar
                                </a>

                                @foreach ($estados as $clave => $etiqueta)
                                    @if ($clave !== $tarea->estado)
                                        <form method="POST" action="{{ route('task.change-status', $tarea) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="estado" value="{{ $clave }}">
                                            <button type="submit"
                                                    class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 px-2 py-1 rounded transition">
                                                → {{ $etiqueta }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach

                                <form method="POST" action="{{ route('task.destroy', $tarea) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar la tarea?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs bg-red-100 hover:bg-red-200 text-red-700 px-2 py-1 rounded transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <p class="text-slate-400 text-sm italic text-center py-6">
                            Sin tareas.
                        </p>
                    @endforelse
                </section>
            @endforeach
        </div>
    </div>
</body>
</html>