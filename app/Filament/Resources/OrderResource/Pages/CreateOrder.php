<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['order_date'] = $data['order_date'] ?? now();
        $data['total_amount'] = collect($data['orderItems'] ?? [])->sum('subtotal');
        
        return $data;
    }

    protected function afterCreate(): void
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