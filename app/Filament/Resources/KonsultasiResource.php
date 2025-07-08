<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KonsultasiResource\Pages;
use App\Filament\Resources\KonsultasiResource\RelationManagers;
use App\Models\Konsultasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KonsultasiResource extends Resource
{
    protected static ?string $model = Konsultasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('dokter_id')
                    ->label('Dokter')
                    ->relationship('dokter', 'nama')
                    ->searchable()
                    ->nullable(),
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required(),
                Forms\Components\TimePicker::make('waktu')
                    ->label('Waktu')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                        'selesai' => 'Selesai',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan'),
                Forms\Components\Textarea::make('hasil_konsultasi')
                    ->label('Hasil Konsultasi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User')->searchable(),
                Tables\Columns\TextColumn::make('dokter.nama')->label('Dokter')->searchable(),
                Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal'),
                Tables\Columns\TextColumn::make('waktu')->label('Waktu'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn($state) => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'diterima' => 'heroicon-o-check-circle',
                        'ditolak' => 'heroicon-o-x-circle',
                        'selesai' => 'heroicon-o-clipboard-document-check',
                        default => null,
                    })
                    ->color(fn($state) => match ($state) {
                        'pending' => 'primary',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        'selesai' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('catatan')->label('Catatan')->limit(20),
                Tables\Columns\TextColumn::make('hasil_konsultasi')->label('Hasil')->limit(20),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListKonsultasis::route('/'),
            'create' => Pages\CreateKonsultasi::route('/create'),
            'edit' => Pages\EditKonsultasi::route('/{record}/edit'),
        ];
    }
}
