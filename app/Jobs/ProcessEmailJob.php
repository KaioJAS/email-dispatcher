<?php

namespace App\Jobs;

use App\Models\Email;
use App\Mail\EmailDispatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Email $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        try {
            Log::info('Processando email ID: ' . $this->email->id);

            $email = Email::find($this->email->id);
            if (!$email || $email->status !== 'pendente') {
                Log::warning('Email não encontrado ou já processado: ' . $this->email->id);
                return;
            }

            $mailable = new EmailDispatch(
                $email->titulo,
                $email->conteudo,
                $email->remetente
            );

            foreach ($email->destinatarios as $destinatario) {
                Log::info("Enviando para: {$destinatario}");
                
                Mail::to($destinatario)->send($mailable);
                
                Log::info("Email enviado com sucesso para: {$destinatario}");
            }

            $email->markAsSent();
            Log::info('Email marcado como enviado: ' . $email->id);

        } catch (Exception $e) {
            Log::error('Erro ao enviar email ID ' . $this->email->id . ': ' . $e->getMessage());
            
            if ($email = Email::find($this->email->id)) {
                $email->markAsError();
            }
            
            throw $e;
        }
    }

    public function failed(Exception $exception)
    {
        Log::error('Job falhou para email ID ' . $this->email->id . ': ' . $exception->getMessage());
        
        if ($email = Email::find($this->email->id)) {
            $email->markAsError();
        }
    }
}