<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    protected $table = 'product_files';

    protected $fillable = [
        'product_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'download_limit',
        'is_active',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'download_limit' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relacionamento com Downloads
     */
    public function downloads()
    {
        return $this->hasMany(Download::class, 'file_id');
    }

    /**
     * Verifica se está ativo
     */
    public function isActive()
    {
        return $this->is_active === true;
    }

    /**
     * Formata tamanho do arquivo
     */
    public function getFormattedSize()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
