<?php

namespace App\Filament\Resources\GuideResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GuideVideosRelationManager extends RelationManager
{
    // Must match Guide::guideVideos() on the model.
    protected static string $relationship = 'guideVideos';

    protected static ?string $title = 'Videos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provider')
                    ->options([
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo',
                        'upload' => 'Direct upload',
                    ])
                    ->default('youtube')
                    ->required(),

                Forms\Components\TextInput::make('video_url')
                    ->label('Video URL')
                    ->url() // validates this looks like a real URL before saving
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('duration_seconds')
                    ->label('Duration (seconds)')
                    ->numeric()
                    ->helperText('Optional -- shown to students as the video length, e.g. 108 for 1:48'),

                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers show first if a guide has more than one video'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('video_url')
            ->defaultSort('sort_order')
            ->reorderable('sort_order') // drag-and-drop reordering, same as steps
            ->columns([
                Tables\Columns\TextColumn::make('provider')
                    ->badge(), // shows as a small colored pill instead of plain text
                Tables\Columns\TextColumn::make('video_url')
                    ->limit(50)
                    ->url(fn ($record) => $record->video_url, shouldOpenInNewTab: true), // clickable, opens the actual video
                Tables\Columns\TextColumn::make('duration_seconds')
                    ->label('Duration'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
