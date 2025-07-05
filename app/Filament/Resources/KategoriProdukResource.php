<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriProdukResource\Pages;
use App\Models\KategoriProduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class KategoriProdukResource extends Resource
{
    protected static ?string $model = KategoriProduk::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $label = 'Kategori Produk';
    protected static ?string $pluralLabel = 'Kategori Produk';
    protected static ?string $navigationGroup = 'Manajemen Katalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kategori')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(KategoriProduk::class, 'slug', ignoreRecord: true)
                    ->maxLength(120),
                Forms\Components\Textarea::make('deskripsi')
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('icon')
                    ->label('Icon (emoji)')
                    ->maxLength(10),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kategori')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('icon')->label('Icon'),
                Tables\Columns\TextColumn::make('produks_count')->counts('produks')->label('Jumlah Produk')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKategoriProduks::route('/'),
            'create' => Pages\CreateKategoriProduk::route('/create'),
            'edit' => Pages\EditKategoriProduk::route('/{record}/edit'),
        ];
    }
}