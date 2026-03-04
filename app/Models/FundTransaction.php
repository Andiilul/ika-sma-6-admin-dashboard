<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class FundTransaction extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'amount',
        'type',
        'transaction_date',
        'category',
        'source',
        'payment_method',
        'proof_image_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date:Y-m-d',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function booted(): void
    {
        static::deleting(function (FundTransaction $tx) {
            if ($tx->proof_image_path) {
                Storage::disk('public')->delete($tx->proof_image_path);
            }
        });
    }
}