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
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Proyecto $proyecto, $pdfPath)
    {
        $this->proyecto = $proyecto;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Nuevo Proyecto.')
        ->view('mails.saludo')
        ->attach($this->pdfPath, [
            'as' => 'proyecto_' . $this->proyecto->cliente->nombre . '.pdf',
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
