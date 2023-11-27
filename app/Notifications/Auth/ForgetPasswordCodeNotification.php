<?php

namespace App\Notifications\Auth;

use App\Mail\Auth\ForgetPasswordCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgetPasswordCodeNotification extends Notification
{
    use Queueable;

    public $verificationCode;

    /**
     * Create a new notification instance.
     *
     * @param $verificationCode
     */
    public function __construct($verificationCode)
    {
        //
        $this->verificationCode = $verificationCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toMail($notifiable): ForgetPasswordCodeMail
    {
        return (new ForgetPasswordCodeMail($notifiable, $this->verificationCode))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
