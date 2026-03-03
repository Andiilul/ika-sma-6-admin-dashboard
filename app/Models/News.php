<?php

namespace App\Models;

use App\Enums\NewsStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',

        'status',
        'published_at',

        'meta_title',
        'meta_description',
        'og_image_path',

        'author_id',
    ];

    protected $casts = [
        'status' => NewsStatus::class,
        'published_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'draft',
    ];

    /**
     * Optional: route model binding pakai slug.
     * /news/{news:slug}
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Author (User) yang membuat news.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function booted(): void
    {
        static::creating(function (News $news) {
            // default status
            if (blank($news->status)) {
                $news->status = NewsStatus::Draft;
            }

            // slug
            if (blank($news->slug)) {
                $news->slug = static::makeUniqueSlug($news->title);
            } else {
                $news->slug = static::makeUniqueSlug($news->slug, treatAsRaw: true);
            }

            // kalau published tapi published_at kosong, isi sekarang
            if (($news->status === NewsStatus::Published) && blank($news->published_at)) {
                $news->published_at = now();
            }
        });

        static::updating(function (News $news) {
            // slug jangan auto berubah ketika title berubah (SEO-friendly)
            if (blank($news->slug)) {
                $news->slug = static::makeUniqueSlug($news->title, ignoreId: $news->getKey());
            }

            // kalau status jadi published tapi published_at kosong, isi sekarang
            if (($news->status === NewsStatus::Published) && blank($news->published_at)) {
                $news->published_at = now();
            }
        });
    }

    protected static function makeUniqueSlug(?string $value, $ignoreId = null, bool $treatAsRaw = false): string
    {
        $base = $treatAsRaw ? Str::slug($value ?? '') : Str::slug($value ?? '');
        if ($base === '') $base = 'news';

        $slug = $base;
        $i = 2;

        $keyName = (new static)->getKeyName();

        while (
            static::query()
                ->when($ignoreId, fn ($q) => $q->where($keyName, '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /**
     * Optional helper scopes (berguna untuk frontend)
     */
    public function scopePublic($query)
    {
        return $query
            ->where('status', NewsStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}