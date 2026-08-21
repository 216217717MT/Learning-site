<?php

namespace App\Filament\Resources\GuideResource\Pages;

use App\Filament\Resources\GuideResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGuide extends CreateRecord
{
    protected static string $resource = GuideResource::class;

    // Runs right before the new Guide is saved to the database.
    // $data is everything the admin typed into the form -- we inject
    // the logged-in admin's ID here so it doesn't need to be a visible
    // field the admin has to fill in themselves.
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by_id'] = auth()->id();
        $data['updated_by_id'] = auth()->id();

        return $data;
    }
}
