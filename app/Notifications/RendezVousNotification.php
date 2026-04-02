<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RendezVousNotification extends Notification
{
    use Queueable;

    protected $statut;
    protected $message_personnalise;

    // On reçoit le statut et un petit message lors de l'envoi
    public function __construct($statut, $message_personnalise = '')
    {
        $this->statut = $statut;
        $this->message_personnalise = $message_personnalise;
    }

    public function via($notifiable)
    {
        return ['mail']; // On dit à Laravel d'envoyer par email
    }

    public function toMail($notifiable)
    {
        $couleur = $this->statut == 'confirmé' ? 'verte' : 'rouge';

        return (new MailMessage)
            ->subject('Mise à jour de votre rendez-vous - Sankara Santé')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Le statut de votre rendez-vous à l\'Université Thomas Sankara a changé.')
            ->line('Nouveau statut : **' . strtoupper($this->statut) . '**')
            ->line($this->message_personnalise)
            ->action('Se connecter à mon espace', url('/dashboard'))
            ->line('Merci de votre confiance.')
            ->salutation('L\'équipe médicale de Sankara Santé');
    }
}