<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class GpNotification extends Notification
{
    use Queueable;

    private $user;
    private $provider;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $provider
     */
    public function __construct($user, $provider)
    {
        //
        $this->user = $user;
        $this->provider = $provider;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->from('Ghost', ':ghost:')
            ->to(env('SLACK_CHANNEL', '#testing'))
            ->content("Provider {$this->provider} is taken by user {$this->user}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
