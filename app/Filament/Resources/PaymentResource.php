<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\RawJs;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaction';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(30),
                Forms\Components\DatePicker::make('payment_date')
                    ->native(false)
                    ->default(now())
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->reactive()
                    ->options(Customer::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('periode_id')
                    ->label('Period')
                    ->reactive()
                    ->options(Periode::query()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\ToggleButtons::make('method')
                    ->inline()
                    ->options([
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'e_wallet' => 'E-Wallet',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('total_payment')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(','),
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
                    ->formatStateUsing(fn (string $state): string => date("d/m/Y", strtotime($state))),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Payment Info')
                ->schema([
                    Infolists\Components\TextEntry::make('number'),
                    Infolists\Components\TextEntry::make('payment_date'),
                    Infolists\Components\TextEntry::make('customer.name'),
                ])->columns(2)
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
            //'view' => Pages\ViewPayment::route('/{record}')
        ];
    }
}
