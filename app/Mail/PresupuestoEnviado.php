<?php
namespace App\Mail;

use App\Models\Presupuesto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PresupuestoEnviado extends Mailable
{
    use Queueable, SerializesModels;
    public $presupuesto;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Presupuesto $presupuesto, $pdfPath)
    {
        $this->presupuesto = $presupuesto;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Adjunto de presupuesto.')
        ->view('mails.saludo')
        ->attach($this->pdfPath, [
            'as' => 'presupuesto_' . $this->presupuesto->cliente->nombre . '.pdf',
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
            subject: 'Presupuesto Enviado',
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
