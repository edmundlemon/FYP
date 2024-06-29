<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Ichtrojan\Otp\Otp;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $subject;
    // public $from;
    public $to;
    private $otp;

    /**
     * Create a new message instance.
     */
    public function __construct(String $otp)
    {
        //
        $this->message = 'Your OTP for resetting password';
        $this->subject = 'Reset Password Email';
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-email',
            with: [
                // 'message' => $this->message,
                'otp' => $this->otp,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
