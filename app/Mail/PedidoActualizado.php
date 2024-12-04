<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;

class PedidoActualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $razon;

    /**
     * Create a new message instance.
     */
    public function __construct(Pedido $pedido, $razon)
    {
        $this->pedido = $pedido;
        $this->razon = $razon;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pedido Actualizado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pedido_actualizado', // Asegúrate de que esta vista exista
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
