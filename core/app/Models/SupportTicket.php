<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'support_tickets';

    protected $fillable = [
        'user_id',
        'product_id',
        'subject',
        'priority',
        'status',
        'closed_at',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relacionamento com Mensagens
     */
    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'ticket_id');
    }

    /**
     * Relacionamento com Anexos
     */
    public function attachments()
    {
        return $this->hasMany(SupportAttachment::class, 'ticket_id');
    }

    /**
     * Verifica se está aberto
     */
    public function isOpen()
    {
        return $this->status === 'open';
    }

    /**
     * Verifica se está fechado
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Verifica se está em progresso
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }
}
