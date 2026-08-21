<?php

namespace App\Filament\Resources\GuideResource\Pages;

use App\Filament\Resources\GuideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuides extends ListRecords
{
    protected static string $resource = GuideResource::class;

    // These two buttons appear top-right on the Guides page.
    protected function getHeaderActions(): array
    {
        return [
            // Downloads a CSV file of whatever guides are currently
            // showing on screen -- if you've filtered by category or
            // status, or typed something in the search box, only those
            // matching guides get exported.
            Actions\Action::make('export')
                ->label('Export CSV')
                ->color('gray')
                ->action(function () {
                    $guides = $this->getFilteredTableQuery()->get();

                    $csv = "Tag,Title,Category,Status,Views,Helpful,Not Helpful\n";

                    foreach ($guides as $guide) {
                        $row = [
                            $guide->tag,
                            $guide->title,
                            $guide->category?->name,
                            $guide->status,
                            $guide->views_count,
                            $guide->helpful_count,
                            $guide->not_helpful_count,
                        ];

                        // Wraps each value in quotes, in case a title has a
                        // comma in it -- keeps the CSV from breaking.
                        $csv .= '"' . implode('","', array_map(
                                fn ($value) => str_replace('"', '""', $value),
                                $row
                            )) . "\"\n";
                    }

                    return response()->streamDownload(function () use ($csv) {
                        echo $csv;
                    }, 'guides.csv');
                }),

            // This button was likely already here before -- creates a
            // brand-new guide. Kept in place either way.
            Actions\CreateAction::make(),
        ];
    }
}
