<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KoperasiMitra extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'slug',
        'website_url',
        'created_by',
        'updated_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Optional helper: kalau kamu ingin auto-generate slug saat create
    protected static function booted(): void
    {
        static::creating(function (KoperasiMitra $mitra) {
            if (empty($mitra->slug) && !empty($mitra->name)) {
                $mitra->slug = Str::slug($mitra->name);
            }
        });

        static::deleting(function (KoperasiMitra $mitra) {
            if ($mitra->logo_path) {
                Storage::disk('public')->delete($mitra->logo_path);
            }
        });
    }
}