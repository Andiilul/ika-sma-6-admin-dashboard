<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

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
     protected static function booted(): void
    {
        // Saat record dihapus -> hapus file
        static::deleting(function (Alumni $alumni) {
            if ($alumni->image_path) {
                Storage::disk('public')->delete($alumni->image_path);
            }
        });

        // Saat update dan image diganti -> hapus file lama
        static::updating(function (Alumni $alumni) {
            if ($alumni->isDirty('image_path')) {
                $old = $alumni->getOriginal('image_path');
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
        });
    }
}
