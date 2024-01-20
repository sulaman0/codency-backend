<?php

namespace App\Notifications\EcgAlert;

use App\AppHelper\FirebaseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EcgAlertNotification extends Notification
{
    use Queueable;

    private int $ecgAlertId;
    private string $alertName;
    private string $locationName;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        int    $ecgAlertId,
        string $alertName,
        string $locationName
    )
    {
        //
        $this->ecgAlertId = $ecgAlertId;
        $this->alertName = $alertName;
        $this->locationName = $locationName;
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
            ->line('Hi, Emergency Code Pressed, ' . $this->alertName . ' At ' . $this->locationName);
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
