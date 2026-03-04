<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KoperasiMitra;
use Illuminate\Http\Request;

class KoperasiMitraController extends Controller
{
    /**
     * GET /api/v1/mitra
     * Public list (pagination)
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
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
            ->orderBy('name');

        $paginator = $query->paginate($validated['per_page'] ?? 15);

        $paginator->getCollection()->transform(function (KoperasiMitra $m) {
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
        });

        return response()->json([
            'status' => 'success',
            'data' => $paginator,
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