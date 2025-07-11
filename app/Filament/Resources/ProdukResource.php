<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Manajemen Katalog';
    protected static ?string $label = 'Produk';
    protected static ?string $pluralLabel = 'Produk';
    protected static ?string $navigationLabel = 'Daftar Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori_produk_id')
                    ->relationship('kategoriProduk', 'nama_kategori')
                    ->label('Kategori Produk')
                    ->required(),
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        fn($state, callable $set, callable $get) =>
                        empty($get('slug')) ? $set('slug', \Str::slug($state)) : null
                    ),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->helperText('Slug otomatis terisi setelah mengisi nama, bisa diedit manual.'),
                Forms\Components\TextInput::make('merk')
                    ->label('Merk'),
                Forms\Components\TextInput::make('berat_volume')
                    ->label('Berat/Volume'),
                Forms\Components\TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status_ketersediaan')
                    ->label('Status Ketersediaan')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Habis' => 'Habis',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('gambar_utama')
                    ->label('Gambar')
                    ->image()
                    ->disk('cloudinary')
                    ->directory('produk')
                    ->maxSize(1024)
                    ->helperText('Ukuran gambar maksimal 1MB')
                    ->required(),
                Forms\Components\DatePicker::make('expired')
                    ->label('Expired'),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')->label('Nama Produk')->searchable(),
                Tables\Columns\TextColumn::make('kategoriProduk.nama_kategori')->label('Kategori'),
                Tables\Columns\TextColumn::make('berat_volume')->label('Berat/Volume'),
                Tables\Columns\TextColumn::make('harga')->label('Harga')->money('IDR'),
                Tables\Columns\TextColumn::make('stok')->label('Stok'),

                Tables\Columns\TextColumn::make('expired')->label('Expired'),
                Tables\Columns\ImageColumn::make('gambar_utama_url')
                    ->label('Gambar'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_produk_id')
                    ->relationship('kategoriProduk', 'nama_kategori')
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('status_ketersediaan')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Habis' => 'Habis',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}