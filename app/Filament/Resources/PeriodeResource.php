<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodeResource\Pages;
use App\Filament\Resources\PeriodeResource\RelationManagers;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;
use Filament\Support\RawJs;

class PeriodeResource extends Resource
{
    protected static ?string $model = Periode::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Setting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->placeholder('Auto')
                    ->maxLength(255)
                    ->extraInputAttributes(['disabled' => true]),
                Forms\Components\TextInput::make('year')
                    ->unique(modifyRuleUsing: function (Unique $rule, callable $get) {
                        // manipulate rule
                        return $rule
                            ->where('year', $get('year'))
                            ->where('month', $get('month'));
                    }, ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Combine year and month has already been taken.',
                    ])
                    ->required()
                    ->numeric()
                    ->maxValue(9999),
                    //->mask(RawJs::make('$money($input)'))
                    //->stripCharacters(','),
                Forms\Components\TextInput::make('month')
                    ->unique(modifyRuleUsing: function (Unique $rule, callable $get) {
                        // manipulate rule
                        return $rule
                            ->where('year', $get('year'))
                            ->where('month', $get('month'));
                    }, ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Combine year and month has already been taken.',
                    ])
                    ->required()
                    ->maxLength(2)
                    ->numeric(),
                Forms\Components\DatePicker::make('start_date')
                    ->format('d/m/Y')
                    ->extraInputAttributes(['disabled' => true]),
                Forms\Components\DatePicker::make('end_date')
                    ->extraInputAttributes(['disabled' => true]),
                Forms\Components\Toggle::make('is_closed')
                    ->label('Closed')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Tables\Columns\TextColumn::make('id')->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('month')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_closed')
                    ->boolean()
                    ->label('Closed'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
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
            'index' => Pages\ListPeriodes::route('/'),
            'create' => Pages\CreatePeriode::route('/create'),
            'edit' => Pages\EditPeriode::route('/{record}/edit'),
        ];
    }

    public static function NewId($year, $month) {
		$mstr = self::ZeroFill($month, 2);
		$period = $year.$mstr;
		return $period;
	}

	public static function ZeroFill($value, $fillfactor){
		$str = str_pad($value, $fillfactor, '0',  STR_PAD_LEFT);
		return $str;
	}

	public static function NamaBulan($value){
		$bulan = array( '01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November','12'=>'Desember');
		return $bulan[$value];
	}
}
