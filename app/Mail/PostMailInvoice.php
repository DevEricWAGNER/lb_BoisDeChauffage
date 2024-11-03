<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class PostMailInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $numero_facture;
    /**
     * Create a new message instance.
     */
    public function __construct(public array $data)
    {
        $this->pdf = $data["pdf"];
        $this->numero_facture = $data["numero_facture"];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre Facture LB Bois de Chauffage',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/public/' . $this->pdf))
                ->as($this->numero_facture)
                ->withMime('application/pdf'),
        ];
    }
}
