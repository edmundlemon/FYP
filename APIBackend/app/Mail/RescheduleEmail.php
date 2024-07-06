<?php

namespace App\Mail;

use App\Models\Consultation_slot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RescheduleEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected string $requestor, protected Consultation_slot $consultation_slot, protected array $formFields)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Slot Rescheduled',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $this->consultation_slot->load('student', 'lecturer');
        $formFields = $this->formFields;
        list($hours, $minutes) = explode(':', $this->consultation_slot->start_time);
        $oldStartTime = $hours . ':' . $minutes;
        list($hours, $minutes) = explode(':', $this->consultation_slot->start_time);
        $oldEndTime = $hours . ':' . $minutes;
        return new Content(
            view: 'emails.reschedule-email',
            with: [
                'requestor' => $this->requestor,
                'newDate' => $formFields['date'],
                'newStartTime' => $formFields['start_time'],
                'newEndTime' => $formFields['end_time'],
            ]
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
