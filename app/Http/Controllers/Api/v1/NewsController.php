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
            'search_title' => ['nullable', 'string', 'max:255'],
            'search_author' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $query = News::query()
            ->public()
            ->with(['author:id,name'])
            ->select([
                'id',
                'title',
                'slug',
                'excerpt',
                'published_at',
                'og_image_path',
                'author_id',
            ]);

        if (!empty($validated['search_title'])) {
            $query->where('title', 'like', '%' . $validated['search_title'] . '%');
        }

        if (!empty($validated['search_author'])) {
            $query->whereHas('author', function ($q) use ($validated) {
                $q->where('name', 'like', '%' . $validated['search_author'] . '%');
            });
        }

        if (!empty($validated['date_from'])) {
            $query->whereDate('published_at', '>=', $validated['date_from']);
        }

        if (!empty($validated['date_to'])) {
            $query->whereDate('published_at', '<=', $validated['date_to']);
        }

        $paginator = $query
            ->orderByDesc('published_at')
            ->paginate($validated['per_page'] ?? 15);

        $items = $paginator->getCollection()->map(function (News $news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug,
                'excerpt' => $news->excerpt,
                'published_at' => $news->published_at?->toISOString(),
                'og_image_url' => $news->og_image_path
                    ? asset('storage/' . $news->og_image_path)
                    : null,
                'author' => $news->author
                    ? [
                        'id' => $news->author->id,
                        'name' => $news->author->name,
                    ]
                    : null,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'data' => $items,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'has_more_pages' => $paginator->hasMorePages(),
            ],
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
                'og_image_url' => $news->og_image_path
                    ? asset('storage/' . $news->og_image_path)
                    : null,
                'author' => $news->author
                    ? [
                        'id' => $news->author->id,
                        'name' => $news->author->name,
                    ]
                    : null,
                'created_at' => $news->created_at?->toISOString(),
                'updated_at' => $news->updated_at?->toISOString(),
            ],
        ]);
    }
}