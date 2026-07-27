<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Textarea::make('excerpt')
                    ->maxLength(500),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('articles'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'مسودة',
                        'published' => 'منشور',
                    ])
                    ->default('draft')
                    ->required(),
                Forms\Components\Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name'),
            ]);
    }

        public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(30),
                Tables\Columns\TextColumn::make('category.name')->sortable()->label('Category'),
                Tables\Columns\TextColumn::make('user.name')->sortable()->label('Author'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ]),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'مسودة',
                        'published' => 'منشور',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
