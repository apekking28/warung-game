<?php

namespace App\Filament\Resources\PublisherResource\Pages;

use App\Filament\Resources\PublisherResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePublisher extends CreateRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
