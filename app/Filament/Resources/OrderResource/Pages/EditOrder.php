<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['total_amount'] = collect($data['orderItems'] ?? [])->sum('subtotal');
        
        return $data;
    }

    protected function afterSave(): void
    {
        $order = $this->record;
        
        // Update total amount after all items are saved
        $totalAmount = $order->orderItems()->sum('subtotal');
        $order->update(['total_amount' => $totalAmount]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}