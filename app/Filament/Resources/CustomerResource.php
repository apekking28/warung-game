<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 2;

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Section::make('Customer Information')
    //                 ->schema([
    //                     TextInput::make('username')
    //                         ->required()
    //                         ->unique(ignoreRecord: true)
    //                         ->maxLength(255),

    //                     TextInput::make('email')
    //                         ->email()
    //                         ->required()
    //                         ->unique(ignoreRecord: true)
    //                         ->maxLength(255),

    //                     TextInput::make('password')
    //                         ->password()
    //                         ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
    //                         ->required(fn (string $operation): bool => $operation === 'create')
    //                         ->maxLength(255),

    //                     TextInput::make('phone')
    //                         ->tel()
    //                         ->required()
    //                         ->maxLength(255),

    //                     Textarea::make('address')
    //                         ->required()
    //                         ->columnSpanFull()
    //                         ->maxLength(65535),
                        
    //                     Toggle::make('active')
    //                         ->required()
    //                         ->default(true)
    //                         ->inline(false),
    //                 ])
    //                 ->columns(2)
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // You can add filters here if needed
                TernaryFilter::make('email_verified')
                    ->label('Email Status')
                    ->placeholder('All users')
                    ->trueLabel('Verified users')
                    ->falseLabel('Unverified users')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verified_at'),
                    ),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            // 'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}