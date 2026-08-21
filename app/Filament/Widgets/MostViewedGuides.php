<?php

namespace App\Filament\Widgets;

use App\Models\Guide;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MostViewedGuides extends BaseWidget
{
    protected static ?string $heading = 'Most viewed guides';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'half';
    //protected int|string|array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Guide::query()->orderByDesc('views_count')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('views_count')->label('Views')->sortable(),
            ])
            ->paginated(false);
    }
}
