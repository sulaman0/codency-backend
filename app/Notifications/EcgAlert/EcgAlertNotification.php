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
    private string $fcmToken;
    private string $alertName;

    /**
     * Create a new notification instance.
     */
    public function __construct(int $ecgAlertId, string $fcmToken, string $alertName)
    {
        //
        $this->ecgAlertId = $ecgAlertId;
        $this->fcmToken = $fcmToken;
        $this->alertName = $alertName;
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
            ->line('Hi, Emergency Code Pressed, ' . $this->alertName);
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

    function sendMobileNotification()
    {
        $payload = [
            'title' => "Emergency ALERT",
            'body' => "Emergency Code Pressed",
            'category' => 'community',
            'data' => [
                'category' => 'ecg_alert',
                'ref' => $this->id
            ]
        ];
        FirebaseNotification::sendFireBaseNotification(
            $payload, [
                $this->fcmToken
            ]
        );
    }
}
