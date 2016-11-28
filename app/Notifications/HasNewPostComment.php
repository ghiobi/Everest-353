<?php

namespace App\Notifications;

use App\Message;
use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class HasNewPostComment extends Notification
{
    use Queueable;

    private $sender;
    private $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, Post $post)
    {
        $this->sender = $sender;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.a
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
            'url' => '/post/' . $this->post->id,
            'message' => $this->sender . ' posted a comment on post, ' . $this->post->name . '.'
        ];
    }
}
