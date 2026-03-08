<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KoperasiMitra;
use Illuminate\Http\Request;

class KoperasiMitraController extends Controller
{
    /**
     * GET /api/v1/mitra
     * Public list with pagination + optional search by name
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search_name' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = KoperasiMitra::query()
            ->select([
                'id',
                'name',
                'description',
                'slug',
                'website_url',
                'logo_path',
                'created_at',
                'updated_at',
            ])
            ->when(
                $validated['search_name'] ?? null,
                fn ($q, $searchName) =>
                $q->where('name', 'like', '%' . $searchName . '%')
            )
            ->orderBy('name');

        $paginator = $query->paginate($validated['per_page'] ?? 15);

        $items = $paginator->getCollection()->map(function (KoperasiMitra $m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'description' => $m->description,
                'slug' => $m->slug,
                'website_url' => $m->website_url,
                'logo_url' => $m->logo_path ? asset('storage/' . $m->logo_path) : null,
                'created_at' => $m->created_at?->toISOString(),
                'updated_at' => $m->updated_at?->toISOString(),
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
     * GET /api/v1/mitra/{slug}
     * Public detail by slug
     */
    public function show(string $slug)
    {
        $m = KoperasiMitra::query()
            ->where('slug', $slug)
            ->first();

        if (!$m) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mitra not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $m->id,
                'name' => $m->name,
                'description' => $m->description,
                'slug' => $m->slug,
                'website_url' => $m->website_url,
                'logo_url' => $m->logo_path ? asset('storage/' . $m->logo_path) : null,
                'created_at' => $m->created_at?->toISOString(),
                'updated_at' => $m->updated_at?->toISOString(),
            ],
        ]);
    }
}