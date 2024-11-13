<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublisherResource\Pages;
use App\Filament\Resources\PublisherResource\RelationManagers;
use App\Models\Publisher;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $label = 'Publisher';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Publisher')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, Set $set) =>
                                    $set('slug', Str::slug($state)))
                                    ->unique(Publisher::class, 'name', ignoreRecord: true),
                                TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->maxLength(255)
                                    ->unique(Publisher::class, 'slug', ignoreRecord: true),
                                    Select::make('country')
                                    ->required()
                                    ->searchable()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        return $data['name'];
                                    })
                                    ->options([
                                        'East Asia' => [
                                            'China' => 'China',
                                            'Japan' => 'Japan',
                                            'Mongolia' => 'Mongolia',
                                            'North Korea' => 'North Korea',
                                            'South Korea' => 'South Korea',
                                            'Taiwan' => 'Taiwan',
                                        ],
                                        'Southeast Asia' => [
                                            'Brunei' => 'Brunei',
                                            'Cambodia' => 'Cambodia',
                                            'Indonesia' => 'Indonesia',
                                            'Laos' => 'Laos',
                                            'Malaysia' => 'Malaysia',
                                            'Myanmar' => 'Myanmar',
                                            'Philippines' => 'Philippines',
                                            'Singapore' => 'Singapore',
                                            'Thailand' => 'Thailand',
                                            'Vietnam' => 'Vietnam',
                                            'Timor-Leste' => 'Timor-Leste',
                                        ],
                                        'South Asia' => [
                                            'Afghanistan' => 'Afghanistan',
                                            'Bangladesh' => 'Bangladesh',
                                            'Bhutan' => 'Bhutan',
                                            'India' => 'India',
                                            'Maldives' => 'Maldives',
                                            'Nepal' => 'Nepal',
                                            'Pakistan' => 'Pakistan',
                                            'Sri Lanka' => 'Sri Lanka',
                                        ],
                                    ])
                                    ->placeholder('Select a country or create new one')
                                    ->live()
                                    ->preload(),
                                TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->maxLength(255),
                            ]),
                        Textarea::make('description')
                            ->required()
                            ->rows(5)
                            ->columnspanfull(),
                        FileUpload::make('logo')
                            ->required()
                            ->image()
                            ->directory('pullishers')
                            ->columnspanfull(),
                        Toggle::make('active')
                            ->required()
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->square()
                    ->size(50),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
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
                IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
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
            ]);
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
            'index' => Pages\ListPublishers::route('/'),
            'create' => Pages\CreatePublisher::route('/create'),
            'edit' => Pages\EditPublisher::route('/{record}/edit'),
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
