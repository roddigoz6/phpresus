<?php

namespace App\Mail;

use App\Models\Proyecto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProyectoEnviado extends Mailable
{
    use Queueable, SerializesModels;
    public $proyecto;
    public $pdfName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Proyecto $proyecto, $pdfName)
    {
        $this->proyecto = $proyecto;
        $this->pdfName = $pdfName;
    }

    public function build()
    {
        $pdfPath = storage_path('app/public/proyectos/' . $this->pdfName);

        return $this->subject('Nuevo proyecto.')
                    ->view('mails.saludo')
                    ->with([
                        'pdfUrl' => url('/storage/proyectos/' . $this->pdfName),
                    ])
                    ->attach($pdfPath, [
                        'as' => 'proyecto.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Proyecto Enviado',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.saludo',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
