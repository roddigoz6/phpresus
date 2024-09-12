<?php

namespace App\Mail;

use App\Models\Proyecto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProformaEnviada extends Mailable
{
    use Queueable, SerializesModels;
    public $proyecto;
    public $pdfName;
    /**
     * Create a new message instance.
     */
    public function __construct(Proyecto $proyecto, $pdfName)
    {
        $this->proyecto = $proyecto;
        $this->pdfName = $pdfName;
    }

    public function build()
    {
        $pdfPath = storage_path('app/public/proformas/' . $this->pdfName);

        return $this->subject('Nueva proforma.')
                    ->view('mails.saludoProf')
                    ->with([
                        'pdfUrl' => url('/storage/proformas/' . $this->pdfName),
                    ])
                    ->attach($pdfPath, [
                        'as' => 'proforma.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Proforma Enviada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.saludoProf',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments()
    {
        return [];
    }
}
