<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'remetente' => $this->remetente,
            'destinatarios' => $this->destinatarios,
            'destinatarios_count' => count($this->destinatarios),
            'destinatarios_formatted' => implode(', ', array_slice($this->destinatarios, 0, 2)) . 
                                       (count($this->destinatarios) > 2 ? ' +' . (count($this->destinatarios) - 2) : ''),
            'conteudo' => $this->conteudo,
            'status' => $this->status,
            'status_formatted' => $this->getStatusFormatted(),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
            'enviado_em' => $this->enviado_em?->format('d/m/Y H:i'),
            'user' => [
                'id' => $this->whenLoaded('user', fn() => $this->user->id),
                'name' => $this->whenLoaded('user', fn() => $this->user->name),
            ]
        ];
    }

    private function getStatusFormatted()
    {
        return match($this->status) {
            'pendente' => 'Aguardando envio',
            'enviado' => 'Enviado',
            'erro' => 'Ocorreu um erro',
            default => $this->status
        };
    }
}