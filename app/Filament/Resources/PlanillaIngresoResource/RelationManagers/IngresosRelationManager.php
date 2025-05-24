<?php

namespace App\Filament\Resources\PlanillaIngresoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\Operario;
use App\Models\Sector;
use Filament\Forms\Components\Hidden;


class IngresosRelationManager extends RelationManager
{
    protected static string $relationship = 'ingresos';

    protected static ?string $title = 'Ingresos asociados';

    public function form(Form $form): Form
    {
        return $form->schema([
            
            Hidden::make('solicitante_id')
            ->default(fn (RelationManager $livewire) => $livewire->ownerRecord->solicitante_id)
            ->required(),


            Forms\Components\Select::make('operario_id')
            ->label('Operario')
            ->relationship('operario', 'nombre_completo')
            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->legajo} - {$record->nombre_completo}")
            ->searchable(['nombre_completo', 'legajo'])
            ->required(),
        

            Forms\Components\Select::make('sector_id')
                ->label('Sector de ingreso')
                ->options(function ($get) {
                    $selectedId = $get('sector_id');
                    $query = \App\Models\Sector::orderBy('nombre')->limit(10);
                    if ($selectedId && ! $query->pluck('id')->contains($selectedId)) {
                        $query->orWhere('id', $selectedId);
                    }
                    return $query->pluck('nombre', 'id');
                })
                
                ->searchable()
                ->preload()
                ->required(),
                

            Forms\Components\DatePicker::make('fecha_ingreso')
                ->required()
                ->label('Fecha de ingreso'),

            Forms\Components\DatePicker::make('fecha_baja')
                ->label('Fecha de baja')
                ->nullable(),

            Forms\Components\Textarea::make('observaciones')
                ->label('Observaciones')
                ->rows(2)
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('operario.nombre_completo')->label('Operario')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('sector.nombre')->label('Sector')->sortable(),
                Tables\Columns\TextColumn::make('fecha_ingreso')->label('Ingreso')->date(),
                Tables\Columns\TextColumn::make('fecha_baja')->label('Baja')->date(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
