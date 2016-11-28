<?php

namespace App\Notifications;

use App\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class HasNewTripUser extends Notification
{
    use Queueable;

    private $rider;
    private $trip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rider, Trip $trip)
    {
        $this->rider = $rider;
        $this->trip = $trip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'url' => '/trip/' . $this->trip->id,
            'message' => $this->rider . ' has joined your trip!',
        ];
    }
}
