<?php

namespace App\Filament\Resources\PeriodeResource\Pages;

use App\Filament\Resources\PeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriode extends EditRecord
{
    protected static string $resource = PeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $startDate = '01'.'/'.$data['month'].'/'.$data['year'];
        $data['start_date'] = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $data['end_date'] = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-t');
        $data['name'] = strtoupper(PeriodeResource::NamaBulan(PeriodeResource::ZeroFill($data['month'],2))).' '.$data['year'];

        return $data;
    }
}
