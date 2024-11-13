<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'Games Management';

    protected static ?string $label = 'Games';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Game Information')
                    ->schema([
                        Select::make('publisher_id')
                            ->relationship('publisher', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->maxLength(65535),
                        TextInput::make('price')
                            ->required()
                            ->prefix('IDR')
                            ->numeric(),
                        // TextInput::make('stock')
                        //     ->required()
                        //     ->numeric()
                        //     ->minValue(0)
                        //     ->maxValue(999999),
                        DatePicker::make('release_date')
                            ->required()
                            ->maxDate(now())
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->image()
                            ->required()
                            ->directory('games')
                            // ->maxSize(5120) // 5MB
                            ->imageEditor()
                            ->columnSpanFull(),
                        Toggle::make('active')
                            ->required()
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->square()
                    ->size(50),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('categories.name')
                    ->badge()
                    ->separator(',')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->words(8)
                    ->tooltip(function (TextColumn $column): ?string {
                        return $column->getState();
                    }),
                TextColumn::make('publisher.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('idr')
                    ->sortable(),
                // TextColumn::make('stock')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('release_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updatedBy.name')
                    ->label("Updated by")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deletedBy.name')
                    ->label("Deleted by")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('publisher')
                    ->relationship('publisher', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Categories')
                    ->placeholder('Select categories'),
                TernaryFilter::make('active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active Games')
                    ->falseLabel('Inactive Games')
                    ->native(false),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
