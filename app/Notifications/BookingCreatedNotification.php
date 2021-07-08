<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    /**
     * The booking model instance
     *
     * @var Booking
     */
    protected $booking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("{$this->booking->location->name} booking created!")
            ->line("Requested for {$this->booking->user->name} from: {$this->booking->started_at} to: {$this->booking->ended_at->format('H:i:s')}")
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        info('I\'m here');
        return (new SlackMessage)
            ->from(config('app.name'))
            // ->image('https://laravel.com/img/favicon/favicon.ico')
            ->content("{$this->booking->location->name} booking created!")
            ->attachment(function ($attachment)  {
                $attachment->title("{$this->booking->location->name} boooking created!")
                    ->content("Requested for {$this->booking->user->name} on: {$this->booking->started_at->format('Y-m-d')} from: {$this->booking->started_at->format('H:i:s')} to: {$this->booking->ended_at->format('H:i:s')}")
                    ->markdown(['text']);
            });
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
