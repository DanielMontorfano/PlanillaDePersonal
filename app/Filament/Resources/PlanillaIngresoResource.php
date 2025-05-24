<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanillaIngresoResource\Pages;
use App\Filament\Resources\PlanillaIngresoResource\RelationManagers;
use App\Models\PlanillaIngreso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Models\Solicitante;


class PlanillaIngresoResource extends Resource
{
    protected static ?string $model = PlanillaIngreso::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('fecha')
            ->label('Fecha de planilla')
            ->default(now()) // ← Esto pone la fecha actual por defecto
            ->required(),
        
    
                TextInput::make('numero')
                ->label('Número de planilla')
                ->disabled() // solo lectura
                ->dehydrated(false) // evita que se envíe en el create
                ->visibleOn('edit'), // solo mostrar en edición
    
                Select::make('solicitante_id')
                    ->label('Solicitante')
                    ->options(function ($get) {
                        $selectedId = $get('solicitante_id');
                        $query = \App\Models\Solicitante::orderBy('nombre_completo')->limit(10);
                        if ($selectedId && ! $query->pluck('id')->contains($selectedId)) {
                            $query->orWhere('id', $selectedId);
                        }
                        return $query->pluck('nombre_completo', 'id');
                    })
                    
                    ->searchable()
                    ->preload()
                    ->required(),
                
    
            Textarea::make('observaciones')
                ->label('Observaciones generales')
                ->rows(3)
                ->nullable(),
        ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
    
                TextColumn::make('numero')
                    ->label('Número')
                    ->sortable(),
    
                TextColumn::make('solicitante.nombre_completo')
                    ->label('Solicitante')
                    ->sortable()
                    ->searchable(),
    
                TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(50),
            ])
            ->defaultSort('fecha', 'desc');
    }
    

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\PlanillaIngresoResource\RelationManagers\IngresosRelationManager::class,
        ];
    }
    

    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanillaIngresos::route('/'),
            'create' => Pages\CreatePlanillaIngreso::route('/create'),
            'edit' => Pages\EditPlanillaIngreso::route('/{record}/edit'),
        ];
    }
}
