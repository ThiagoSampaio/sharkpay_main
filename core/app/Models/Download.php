<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'downloads';

    protected $fillable = [
        'user_id',
        'product_id',
        'file_id',
        'ip_address',
        'user_agent',
        'download_count',
    ];

    protected $casts = [
        'download_count' => 'integer',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

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
     * Relacionamento com ProductFile
     */
    public function file()
    {
        return $this->belongsTo(ProductFile::class, 'file_id');
    }

    /**
     * Incrementa contador
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}
