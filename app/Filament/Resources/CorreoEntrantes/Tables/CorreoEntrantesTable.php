<?php

namespace App\Filament\Resources\CorreoEntrantes\Tables;

use App\Models\Area;
use App\Models\Expediente;
use App\Models\Movimiento;
use App\Models\TipoDocumento;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class CorreoEntrantesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha_recepcion_correo')
                    ->label('Fecha')
                    ->dateTime('d/m/Y', 'H:i')
                    ->sortable(),
                TextColumn::make('remitente_email')
                    ->label('Remitente')
                    ->searchable(),
                TextColumn::make('asunto')
                    ->limit(50)
                    ->searchable(),
                IconColumn::make('tiene_adjuntos')
                    ->label('Adjuntos')
                    ->boolean(),
                IconColumn::make('procesado')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('succes')
                    ->falseColor('warning')
            ])
            ->defaultSort('fecha_recepcion_correo', 'desc')
            ->filters([
                TernaryFilter::make('procesado')
                    ->label('¿Ya fue derivado?')
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('derivar')
                    ->label('Derivar a Especialista')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Convertir correo en expediente')
                    ->modalDescription('Al confirmar, se creará un número de registro AGP y se notificará al área destino.')
                    ->hidden(fn($record) => $record->procesado) //se oculta si ya se derivo
                    ->form([
                        Select::make('tipo_documento_id')
                            ->label('Tipo de Documento')
                            ->options(TipoDocumento::pluck('nombre', 'id'))
                            ->required(),
                        Select::make('area_destino_id')
                            ->label('Derivar a (Sub-área)')
                            ->options(Area::pluck('nombre', 'id')) // En el futuro, filtraremos solo hijas de AGP
                            ->searchable()
                            ->required(),
                        Textarea::make('proveido')
                            ->label('Proveído (Instrucción)')
                            ->placeholder('Ej: Proceder con la revisión de la solicitud...')
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                    // Usamos una Transacción para asegurar que todo se guarde o nada
                    DB::transaction(function () use ($data, $record) {

                        // 1. Crear el Expediente
                        $expediente = Expediente::create([
                            'numero_registro' => 'AGP-' . date('Y') . '-' . str_pad(Expediente::count() + 1, 4, '0', STR_PAD_LEFT),
                            'asunto' => $record->asunto,
                            'tipo_documento_id' => $data['tipo_documento_id'],
                            'email_remitente_temporal' => $record->remitente_email,
                            'estado_actual_id' => 1, // Asumiendo que 1 es 'Pendiente' o 'Derivado'
                            'area_actual_id' => $data['area_destino_id'],
                            // usuario_origen_id queda null porque vino de un correo externo
                        ]);

                        // 2. Registrar el Movimiento (La Hoja de Ruta)
                        Movimiento::create([
                            'expediente_id' => $expediente->id,
                            'area_origen_id' => auth()->user()->area_id ?? 1, // Área de quien está logueado (Jefe AGP)
                            'usuario_origen_id' => auth()->id(),
                            'area_destino_id' => $data['area_destino_id'],
                            'estado_id' => 1,
                            'proveido' => $data['proveido'],
                        ]);

                        // 3. Marcar el correo como procesado y vincularlo
                        $record->update([
                            'procesado' => true,
                            'expediente_id' => $expediente->id,
                        ]);

                        // NOTA: La lógica para mover los archivos adjuntos a la tabla `archivos_adjuntos` iría aquí.
                    });
                })
                ->successNotificationTitle('¡Expediente generado y derivado correctamente!'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
