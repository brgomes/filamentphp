<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Editar usuário';

    protected static ?string $breadcrumb = 'Editar';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /*protected function afterSave(): void
    {
        $recipient = Auth::user();

        Log::info('User updated');

        Notification::make()
            ->title('Usuário atualizado')
            ->sendToDatabase($recipient);
    }*/

    protected function getSavedNotification(): ?Notification
    {
        $recipient = Auth::user();

        return Notification::make()
            ->success()
            ->title('User updated')
            ->body('The user has been saved successfully.')
            ->sendToDatabase($recipient);
    }
}
