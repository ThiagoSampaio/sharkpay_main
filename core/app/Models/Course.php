<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'product_id',
        'title',
        'description',
        'duration',
        'lessons_count',
        'certificate_enabled',
    ];

    protected $casts = [
        'certificate_enabled' => 'boolean',
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
     * Verifica se tem certificado
     */
    public function hasCertificate()
    {
        return $this->certificate_enabled === true;
    }
}
