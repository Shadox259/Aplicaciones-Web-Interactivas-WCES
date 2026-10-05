<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva tarea</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-2xl shadow-lg max-w-xl w-full p-8">

        <h1 class="text-2xl font-bold text-slate-900 mb-6">Nueva tarea</h1>

        <form method="POST" action="{{ route('task.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Título *</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('titulo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="4"
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
                @error('descripcion') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Estado *</label>
                    <select name="estado" required
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($estados as $clave => $etiqueta)
                            <option value="{{ $clave }}" @selected(old('estado') === $clave)>{{ $etiqueta }}</option>
                        @endforeach
                    </select>
                    @error('estado') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Prioridad *</label>
                    <select name="prioridad" required
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($prioridades as $clave => $etiqueta)
                            <option value="{{ $clave }}" @selected(old('prioridad') === $clave)>{{ $etiqueta }}</option>
                        @endforeach
                    </select>
                    @error('prioridad') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Vencimiento *</label>
                <input type="date" name="vencimiento" value="{{ old('vencimiento') }}" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('vencimiento') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg transition">
                    Guardar
                </button>
                <a href="{{ route('task.index') }}"
                   class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-medium px-5 py-2 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</body>
</html>