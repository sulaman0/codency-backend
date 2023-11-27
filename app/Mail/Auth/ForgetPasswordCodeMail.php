<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private string $user;
    private string $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $user = json_decode($this->user);
        return $this->view('email_templates.auth.forget_password_code', [
            'username' => $user->name,
            'verificationCode' => $this->code,
        ])->subject(__('notification.user.reset_password_code'));
    }
}
