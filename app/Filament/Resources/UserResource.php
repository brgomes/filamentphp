<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Cadastro de usuários';
 
    protected static ?int $navigationSort = 1;

    protected static ?string $breadcrumb = 'Usuários';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados do usuário')
                    ->description('A senha será enviada por e-mail para o usuário')
                    //->aside()
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->placeholder('Digite o nome do usuário'),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required(),
                        Toggle::make('active')
                            ->default(true),
                    ])
                    ->icon('heroicon-o-user'),
                Section::make('Segurança')
                    ->description('Informe a senha com no mínimo 8 caracteres')
                    //->aside()
                    ->collapsible()
                    ->schema([
                        TextInput::make('password')
                            ->label('Senha')
                            ->required()
                            ->confirmed()
                            ->revealable()
                            ->password(),
                        TextInput::make('password_confirmation')
                            ->label('Confirme a senha')
                            ->revealable()
                            ->password(),
                    ])
                    ->icon('heroicon-o-lock-closed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('active')
                    ->label('Ativo'),
            ])
            ->filters([
                SelectFilter::make('active')
                    ->options([
                        true => 'Ativos',
                        false => 'Inativos',
                    ])
                    ->label('Ativo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Alterar usuário')
                    ->icon('heroicon-m-pencil-square')
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Ativar selecionado')
                        ->color('success')
                        ->requiresConfirmation()
                        ->icon('heroicon-s-check-circle')
                        ->action(fn(Collection $users) => $users->each->update(['active' => true]))
                        ->after(fn() => Notification::make()->title('Usuários ativados com sucesso!')->success()->send()),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
