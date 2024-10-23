<?php

namespace App\Mail;

use App\Models\Presupuesto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PresupuestoEnviado extends Mailable
{
    use Queueable, SerializesModels;
    public $presupuesto;
    public $pdfName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Presupuesto $presupuesto, $pdfName)
    {
        $this->presupuesto = $presupuesto;
        $this->pdfName = $pdfName;
    }

    public function build()
    {
        $pdfPath = storage_path('app/public/presupuestos/' . $this->pdfName);

        return $this->subject('Nuevo presupuesto.')
                    ->view('mails.saludo')
                    ->with([
                        'pdfUrl' => url('/storage/presupuestos/' . $this->pdfName),
                    ])
                    ->attach($pdfPath, [
                        'as' => 'presupuesto.pdf',
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
