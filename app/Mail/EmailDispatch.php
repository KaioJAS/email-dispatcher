<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailDispatch extends Mailable
{
    use Queueable, SerializesModels;

    public $titulo;
    public $conteudo;
    public $remetente;

    public function __construct($titulo, $conteudo, $remetente)
    {
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->remetente = $remetente;
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->titulo,
            replyTo: [$this->remetente],
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.dispatch',
        );
    }

    public function attachments()
    {
        return [];
    }
}