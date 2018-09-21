<?php


namespace App\Mailer;


use App\User;
use Illuminate\Support\Facades\Mail;

class AppMailer {

    protected $from = 'iadosiga@gmail.com';

    protected $to;
    protected $view;
    protected $data = [];

    /**
     * @param User $user
     */
    public function sendEmailConfirmation(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $this->data = compact('user');

        $this->send();
    }

    /**
     * Send and email
     */
    private function send()
    {
        Mail::send($this->view, $this->data, function($message){
            $message->from($this->from, 'SIGA System')
                    ->to($this->to)
                    ->subject('Inscription dans la FSR');
        });
    }



}