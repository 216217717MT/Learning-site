<?php

namespace App\Filament\Widgets;

use App\Models\Guide;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class NeedsReviewGuides extends BaseWidget
{
    protected static ?string $heading = 'Needs review';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'half';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Guide::query()
                    ->where('status', 'published')
                    ->whereRaw('not_helpful_count > helpful_count')
                    ->whereRaw('(helpful_count + not_helpful_count) >= 3')
                    ->orderByRaw('(not_helpful_count - helpful_count) desc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('helpful_count')->label('Helpful'),
                Tables\Columns\TextColumn::make('not_helpful_count')->label('Still stuck'),
            ])
            ->paginated(false);
    }
}
