<?php

namespace App\Filament\Resources\GuideResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GuideStepsRelationManager extends RelationManager
{
    // This must match the relationship method name on the Guide model
    // (Guide::guideSteps()), not the table name -- Filament uses this
    // to know which related records to load and save.
    protected static string $relationship = 'guideSteps';

    // Shown as the section title on the Guide edit page.
    protected static ?string $title = 'Steps';

    // The form used when adding or editing a single step
    // (opens in a modal when you click "New" or "Edit" in the table below).
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('step_number')
                    ->label('Step #')
                    ->numeric()
                    ->required()
                    ->default(fn () => $this->getOwnerRecord()->guideSteps()->max('step_number') + 1),
                // Auto-suggests the next step number based on how many
                // steps this guide already has, so the admin doesn't
                // have to count manually.

                Forms\Components\Textarea::make('content')
                    ->label('Step instructions')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    // The table listing all steps for this guide, shown directly on the
    // Guide edit page (this is what replaces the "Steps" textarea from
    // the HTML prototype's admin form).
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('content')
            ->defaultSort('step_number')
            // Lets the admin drag-and-drop rows to reorder steps; updates
            // the step_number column automatically when dropped.
            ->reorderable('step_number')
            ->columns([
                Tables\Columns\TextColumn::make('step_number')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->wrap() // allows long step text to wrap instead of being cut off
                    ->limit(120),
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
