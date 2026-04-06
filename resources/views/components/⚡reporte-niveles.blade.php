<?php

use Livewire\Component;
use App\Models\Institucion;
use App\Models\Grado;
use App\Models\Competencia;
use App\Models\Periodo;
use App\Models\Reporte;
use App\Models\ReporteDetalle;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public $ie_id = '';
    public $grado_id = '';
    public $nombre_docente = '';
    public $competencias = [];
    public $resultados = [];

    // Este método se ejecuta automáticamente cuando cambia $grado_id
    public function updatedGradoId($value)
    {
        if ($value) {
            $this->competencias = Competencia::with('curso')->where('grado_id', $value)->get();

            foreach ($this->competencias as $comp) {
                $this->resultados[$comp->id] = [
                    'ad' => 0,
                    'a' => 0,
                    'b' => 0,
                    'c' => 0,
                ];
            }
        } else {
            $this->competencias = [];
            $this->resultados = [];
        }
    }

    public function enviarReporte()
    {
        $this->validate([
            'ie_id' => 'required',
            'grado_id' => 'required',
            'nombre_docente' => 'required|string|max:255',
        ]);

        $periodoActivo = Periodo::where('is_active', true)->first();

        if (!$periodoActivo) {
            session()->flash('error', 'No hay un periodo académico activo para enviar el reporte.');
            return;
        }

        DB::transaction(function () use ($periodoActivo) {
            $reporte = Reporte::create([
                'ie_id' => $this->ie_id,
                'grado_id' => $this->grado_id,
                'periodo_id' => $periodoActivo->id,
                'fecha_envio' => now(),
                'ip_origen' => request()->ip(),
                'nombre_docente' => $this->nombre_docente,
            ]);

            foreach ($this->resultados as $compId => $valores) {
                ReporteDetalle::create([
                    'reporte_id' => $reporte->id,
                    'competencia_id' => $compId,
                    // Aseguramos que se guarde un número y si está vacío sea 0
                    'cant_ad' => (int) ($valores['ad'] ?? 0),
                    'cant_a' => (int) ($valores['a'] ?? 0),
                    'cant_b' => (int) ($valores['b'] ?? 0),
                    'cant_c' => (int) ($valores['c'] ?? 0),
                ]);
            }
        });

        session()->flash('mensaje', 'Reporte enviado con éxito.');

        // Redirige y limpia el formulario
        return $this->redirect('/reporte-docentes', navigate: true);
    }

    // Usamos el método with() para pasar datos a la vista en componentes de un solo archivo
    public function with(): array
    {
        return [
            'instituciones' => Institucion::all(),
            'grados' => Grado::all(),
        ];
    }
};
?>

<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-8">
    <h2 class="text-2xl font-bold mb-6 text-purple-800">Reporte de Logros de Aprendizaje</h2>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('mensaje') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Docente</label>
            <input type="text" wire:model="nombre_docente" placeholder="Ej: Juan Pérez"
                class="w-full border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500">
            @error('nombre_docente')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Institución Educativa</label>
            <select wire:model="ie_id"
                class="w-full border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500">
                <option value="">-- Buscar IE --</option>
                @foreach ($instituciones as $ie)
                    <option value="{{ $ie->id }}">{{ $ie->nombre }}</option>
                @endforeach
            </select>
            @error('ie_id')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Grado / Año</label>
            <select wire:model.live="grado_id"
                class="w-full border-gray-300 rounded focus:ring-purple-500 focus:border-purple-500">
                <option value="">-- Seleccionar --</option>
                @foreach ($grados as $grado)
                    <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
                @endforeach
            </select>
            @error('grado_id')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>

    @if (count($competencias) > 0)
        <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Curso
                            / Competencia</th>
                        <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 w-24">AD
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 w-24">A
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 w-24">B
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 w-24">C
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($competencias as $comp)
                        <tr>
                            <td class="whitespace-normal py-4 pl-4 pr-3 text-sm text-gray-500">
                                <span class="font-bold text-purple-700">{{ $comp->curso->nombre }}</span><br>
                                {{ $comp->descripcion }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <input type="number" min="0" wire:model="resultados.{{ $comp->id }}.ad"
                                    class="w-full text-center border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <input type="number" min="0" wire:model="resultados.{{ $comp->id }}.a"
                                    class="w-full text-center border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <input type="number" min="0" wire:model="resultados.{{ $comp->id }}.b"
                                    class="w-full text-center border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <input type="number" min="0" wire:model="resultados.{{ $comp->id }}.c"
                                    class="w-full text-center border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end">
            <button wire:click="enviarReporte"
                class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                Enviar Reporte Final
            </button>
        </div>
    @endif
</div>
