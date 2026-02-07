<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;


class Activity extends Model
{
    use HasUuids;

    // UUID primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'date',
        'location',
        'image',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
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
        static::deleting(function (Activity $activity) {
            if ($activity->image_path) {
                Storage::disk('public')->delete($activity->image_path);
            }
        });

        static::updating(function (Activity $activity) {

            static::saving(function (Alumni $alumni) {
                if (auth()->check()) {
                    $alumni->updated_by = auth()->id();
                }
            });
            if ($activity->isDirty('image_path')) {
                $old = $activity->getOriginal('image_path');
                if ($old) {
                    Storage::disk('public')->delete($old);
                }
            }
        });
    }
}

