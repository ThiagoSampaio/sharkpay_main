<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = 'api_keys';

    protected $fillable = [
        'name',
        'key',
        'permissions',
        'active',
        'last_used_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'active' => 'boolean',
        'last_used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Verifica se está ativa
     */
    public function isActive()
    {
        return $this->active === true;
    }

    /**
     * Verifica se tem permissão
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions);
    }

    /**
     * Atualiza último uso
     */
    public function updateLastUsed()
    {
        $this->last_used_at = now();
        $this->save();
    }

    /**
     * Oculta a chave ao serializar
     */
    protected $hidden = ['key'];
}
