<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * GET /api/v1/news
     * Public list (ONLY published). No content.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = News::query()
            ->public() // ✅ ONLY published
            ->with(['author:id,name'])
            ->select([
                'id',
                'title',
                'slug',
                'excerpt',
                'status',
                'published_at',
                'meta_title',
                'meta_description',
                'og_image_path',
                'author_id',
                'created_at',
                'updated_at',
            ])
            ->orderByDesc('published_at');

        $paginator = $query->paginate($validated['per_page'] ?? 15);

        $paginator->getCollection()->transform(function (News $news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug,
                'excerpt' => $news->excerpt,
                'published_at' => $news->published_at?->toISOString(),
                'og_image_url' => $news->og_image_path ? asset('storage/' . $news->og_image_path) : null,
                'author' => $news->author ? ['id' => $news->author->id, 'name' => $news->author->name] : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $paginator,
        ]);
    }

    /**
     * GET /api/v1/news/{slug}
     * Public detail by slug.
     *
     * - 404 if not found
     * - 403 if found but not published/public
     */
    public function show(string $slug)
    {
        $news = News::query()
            ->with(['author:id,name'])
            ->where('slug', $slug)
            ->first();

        if (!$news) {
            return response()->json([
                'status' => 'error',
                'message' => 'News not found.',
            ], 404);
        }

        // ✅ only allow published/public
        $isPublic = News::query()->public()->whereKey($news->getKey())->exists();
        if (!$isPublic) {
            return response()->json([
                'status' => 'error',
                'message' => 'This news is not published.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug,
                'excerpt' => $news->excerpt,
                'content' => $news->content,
                'published_at' => $news->published_at?->toISOString(),
                'meta_title' => $news->meta_title,
                'meta_description' => $news->meta_description,
                'og_image_url' => $news->og_image_path ? asset('storage/' . $news->og_image_path) : null,
                'author' => $news->author ? ['id' => $news->author->id, 'name' => $news->author->name] : null,
                'created_at' => $news->created_at?->toISOString(),
                'updated_at' => $news->updated_at?->toISOString(),
            ],
        ]);
    }
}