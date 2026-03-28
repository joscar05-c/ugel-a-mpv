@php
    // Usamos $getState() que es la forma nativa de Filament para obtener el valor del campo actual
    $archivos = $getState() ?? [];

    // Por si acaso la base de datos lo está devolviendo como texto JSON crudo
    if(is_string($archivos)) {
        $archivos = json_decode($archivos, true);
    }
@endphp

@if (is_array($archivos) && count($archivos) > 0)
    <div class="flex flex-col gap-4">
        @foreach ($archivos as $ruta)
            @php
                // Usamos las rutas completas de las fachadas para que Blade no arroje error
                $esPdf = \Illuminate\Support\Str::endsWith(strtolower($ruta), '.pdf');
                $urlPublica = \Illuminate\Support\Facades\Storage::url($ruta);
            @endphp
            <div class="w-full border rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-900">
                @if ($esPdf)
                    <iframe src="{{ $urlPublica }}" class="w-full" style="height: 75vh;" frameborder="0"></iframe>
                @else
                    <div class="p-4 text-center">
                        <p class="text-sm text-gray-500">Archivo adjunto no es un PDF.</p>
                        <a href="{{ $urlPublica }}" target="_blank" class="text-primary-600 font-bold underline">
                            Descargar {{ basename($ruta) }}
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="p-4 text-center text-gray-500 bg-gray-50 rounded-lg dark:bg-gray-900 border border-dashed border-gray-300">
        No se encontraron rutas de archivos asociadas a este correo en la base de datos.
    </div>
@endif
