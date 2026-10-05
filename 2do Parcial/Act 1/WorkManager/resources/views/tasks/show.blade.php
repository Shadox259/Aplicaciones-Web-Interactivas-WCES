<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tarea->titulo }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-2xl shadow-lg max-w-xl w-full p-8">

        <h1 class="text-2xl font-bold text-slate-900 mb-6">{{ $tarea->titulo }}</h1>

        @php
            $coloresPrioridad = [
                'baja'  => 'bg-emerald-500',
                'media' => 'bg-amber-500',
                'alta'  => 'bg-red-500',
            ];
            $coloresEstado = [
                'por_hacer' => 'bg-slate-500',
                'en_curso'  => 'bg-blue-500',
                'terminado' => 'bg-emerald-500',
            ];
        @endphp

        <dl class="space-y-4">
            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Descripción</dt>
                <dd class="text-slate-800 mt-1">{{ $tarea->descripcion ?: '—' }}</dd>
            </div>

            <div class="flex gap-6">
                <div>
                    <dt class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Estado</dt>
                    <dd class="mt-1">
                        <span class="text-white text-xs px-3 py-1 rounded-full {{ $coloresEstado[$tarea->estado] ?? 'bg-slate-500' }}">
                            {{ $estados[$tarea->estado] ?? $tarea->estado }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Prioridad</dt>
                    <dd class="mt-1">
                        <span class="text-white text-xs px-3 py-1 rounded-full {{ $coloresPrioridad[$tarea->prioridad] ?? 'bg-slate-500' }}">
                            {{ $prioridades[$tarea->prioridad] ?? $tarea->prioridad }}
                        </span>
                    </dd>
                </div>
            </div>

            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Vencimiento</dt>
                <dd class="text-slate-800 mt-1">{{ $tarea->vencimiento->format('d/m/Y') }}</dd>
            </div>

            <div>
                <dt class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Creada</dt>
                <dd class="text-slate-800 mt-1">{{ $tarea->created_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>

        <div class="flex gap-3 pt-6">
            <a href="{{ route('task.edit', $tarea) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                Editar
            </a>
            <a href="{{ route('task.index') }}"
               class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-medium px-5 py-2 rounded-lg transition">
                Volver
            </a>
        </div>
    </div>
</body>
</html>