<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailToAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $code;
    public $email;

    public function __construct($codeToSendo,$emailToSend)
    {
        $this->code = $codeToSendo;
        $this->email = $emailToSend;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Création de compte Administrateur')
                    ->line('Bonjour.')
                    ->line('Votre compte à été créer sur la plateforme de God\'s Grace For Kids.')
                    ->line('Cliquez sur le bouton ci-dessous pour valider votre compte.')
                    ->line('Veuillez saisir le code '.$this->code.' dans le formulaire qui vous sera soumis.')
                    ->action('Cliquez ici', url('/validate-account' . '/' . $this->email))
                    ->line('Merci d\'utilisaer nos services!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
