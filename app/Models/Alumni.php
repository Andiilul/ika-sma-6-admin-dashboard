<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Alumni extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'nisn',
        'gender',
        'graduation_year',
        'ethnicity',
        'domicile',
        'address',
        'profession',
        'position',
        'location',
        'hobby',
        'contact_number',
        'image_path',   // atau image_url
        'updated_by',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Opsional: biar gampang ambil email editor terakhir
    public function getUpdatedByEmailAttribute(): ?string
    {
        return $this->updatedBy?->email;
    }
}
