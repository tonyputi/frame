<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class BookingUpdatedNotification extends BookingCreatedNotification
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("{$this->booking->location->name} booking updated!")
            ->line("Requested for {$this->booking->user->name} from: {$this->booking->started_at} to: {$this->booking->ended_at}")
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
