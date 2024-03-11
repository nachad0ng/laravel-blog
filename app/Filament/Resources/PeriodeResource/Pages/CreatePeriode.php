<?php

namespace App\Filament\Resources\PeriodeResource\Pages;

use App\Filament\Resources\PeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePeriode extends CreateRecord
{
    protected static string $resource = PeriodeResource::class;


    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User registered')
            ->body('The user has been created successfully.');
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $startDate = '01'.'/'.$data['month'].'/'.$data['year'];
        $data['start_date'] = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $data['end_date'] = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-t');
        $data['name'] = strtoupper($this->resource::NamaBulan($this->resource::ZeroFill($data['month'],2))).' '.$data['year'];
        $data['id'] = $this->resource::NewId($data['year'], $data['month']);

        return $data;
    }

}
