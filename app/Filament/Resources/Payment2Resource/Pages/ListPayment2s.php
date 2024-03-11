<?php

namespace App\Filament\Resources\Payment2Resource\Pages;

use App\Filament\Resources\Payment2Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayment2s extends ListRecords
{
    protected static string $resource = Payment2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
