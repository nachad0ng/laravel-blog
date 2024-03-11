<?php

namespace App\Filament\Resources\Payment2Resource\Pages;

use App\Filament\Resources\Payment2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayment2 extends EditRecord
{
    protected static string $resource = Payment2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
