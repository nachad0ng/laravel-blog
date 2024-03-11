<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Payment2Resource\Pages;
use App\Filament\Resources\Payment2Resource\RelationManagers;
use App\Models\Customer;
use App\Models\Payment2;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Payment2Resource extends Resource
{
    protected static ?string $model = Payment2::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(30),
                Forms\Components\DatePicker::make('payment_date')
                    ->format('d/m/Y')
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    //->relationship('customer', 'name')
                    ->options(Customer::pluck('name', 'id'))
                    ->default(null)
                    ->searchable(),
                Forms\Components\Select::make('periode_id')
                    ->relationship('periode', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('method')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_payment')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_payment')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayment2s::route('/'),
            'create' => Pages\CreatePayment2::route('/create'),
            'edit' => Pages\EditPayment2::route('/{record}/edit'),
        ];
    }
}
