<?php

namespace App\Filament\Widgets;

use App\Models\SearchLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SearchGapsWidget extends BaseWidget
{
    protected static ?string $heading = 'Searches with no results';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';
    //protected int|string|array $columnSpan = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SearchLog::query()
                    // MIN(id) gives each grouped row a real, unique ID value
                    // -- without this, Filament has nothing to use as a
                    // row identifier and crashes when the table updates.
                    ->selectRaw('MIN(id) as id, normalized_query, count(*) as times_searched')
                    ->where('result_count', 0)
                    ->groupBy('normalized_query')
                    ->orderByDesc('times_searched')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('normalized_query')->label('Search term'),
                Tables\Columns\TextColumn::make('times_searched')->label('Times searched'),
            ])
            ->paginated(false);
    }
}
