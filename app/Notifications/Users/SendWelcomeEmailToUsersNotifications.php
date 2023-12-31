<?php

namespace App\Notifications\Users;

use App\Mail\Users\SendWelcomeEmailToUsersMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SendWelcomeEmailToUsersNotifications extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
    public function toMail(object $notifiable): SendWelcomeEmailToUsersMail
    {
        return (new SendWelcomeEmailToUsersMail($notifiable))->to($notifiable->email);
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
