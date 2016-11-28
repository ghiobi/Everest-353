<?php

namespace App\Notifications;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class HasNewMail extends Notification
{
    use Queueable;

    private $message;
    private $sender;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, Message $message)
    {
        $this->message = $message;
        $this->sender = $name;
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
     * Get the representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'url' => '/mail',
            'message' => 'New email from ' . $this->sender . '.'
        ];
    }
}
