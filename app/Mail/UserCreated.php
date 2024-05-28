<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.created')->
            subject('Tu nueva cuenta de la Carta Etnogográfica de Canarias está lista')->
            with([
            'user' => $this->user,
            'password' => $this->password
        ]);
    }
}
