<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $table = 'support_messages';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
        'is_staff',
    ];

    protected $casts = [
        'is_staff' => 'boolean',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com Ticket
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    /**
     * Relacionamento com User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica se é mensagem da equipe
     */
    public function isStaffMessage()
    {
        return $this->is_staff === true;
    }
}
