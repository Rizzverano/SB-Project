<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SbmemberResource\Pages;
use App\Models\Sbmember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

// ✅ Correct Filament 4 table columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\CheckboxColumn;

// Forms
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class SbmemberResource extends Resource
{
    protected static ?string $model = Sbmember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Officials';

    protected static ?string $navigationLabel = 'SB Members';

    protected static ?string $modelLabel = 'SB Member';

    protected static ?string $pluralModelLabel = 'SB Members';

    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('image')
                ->image()
                ->directory('sbmembers')
                ->label('Image'),

            TextInput::make('name')
                ->placeholder('e.g. Hon. John Doe, etc.')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->placeholder('e.g. SB Member, Majority Floor Leader, etc.')
                ->rows(4)
                ->required()
                ->columnSpanFull(),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Toggle::make('is_publish')
                        ->label('Publish SB Member')
                        ->helperText('Enable to make this visible to users.')
                        ->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->where('is_archived', false)
                ->latest())
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->defaultImageUrl(asset('images/default.jpg')),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->limit(50),

                CheckboxColumn::make('is_publish')
                    ->label('Published')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('archive')
                    ->label('Mark as Former')
                    ->icon('heroicon-o-user-group')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Mark as Former SB Member')
                    ->modalDescription('Are you sure you want to mark this SB member as former?')
                    ->modalSubmitActionLabel('Mark as Former')
                    ->action(function (Sbmember $record) {
                        $record->update([
                            'is_archived' => true,
                            'is_publish' => false,
                        ]);

                        Notification::make()
                            ->title('SB Member Marked as Former')
                            ->body('The SB member has been marked as former successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('archive')
                    ->label('Mark Selected as Former')
                    ->icon('heroicon-o-user-group')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Mark SB Members as Former')
                    ->modalDescription('Are you sure you want to mark the selected SB members as former?')
                    ->modalSubmitActionLabel('Mark as Former')
                    ->action(function ($records) {
                        $records->each->update([
                            'is_archived' => true,
                            'is_publish' => false,
                        ]);

                        Notification::make()
                            ->title('SB Members Marked as Former')
                            ->body('Selected SB members have been marked as former successfully.')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSbmembers::route('/'),
            'create' => Pages\CreateSbmember::route('/create'),
            'edit' => Pages\EditSbmember::route('/{record}/edit'),
        ];
    }
}
