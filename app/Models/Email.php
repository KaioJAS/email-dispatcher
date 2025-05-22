<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'remetente',
        'remetente_id',
        'destinatarios',
        'conteudo',
        'status',
        'enviado_em',
    ];

    protected function casts(): array
    {
        return [
            'destinatarios' => 'array',
            'enviado_em' => 'datetime',
        ];
    }

    /**
     * Relacionamento com usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    /**
     * Scope para status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para emails recentes
     */
    public function scopeRecent($query)
    {
        return $query->latest('created_at');
    }

    /**
     * Accessor para formatar destinatários
     */
    protected function destinatariosFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => is_array($this->destinatarios) 
                ? implode(', ', $this->destinatarios) 
                : $this->destinatarios,
        );
    }

    /**
     * Marcar como enviado
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'enviado',
            'enviado_em' => now(),
        ]);
    }

    /**
     * Marcar como erro
     */
    public function markAsError(): void
    {
        $this->update(['status' => 'erro']);
    }
}