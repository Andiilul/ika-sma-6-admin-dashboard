<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\KoperasiMember;
use Illuminate\Http\Request;

class KoperasiMemberController extends Controller
{
    /**
     * GET /api/v1/members
     * Public list (pagination)
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = KoperasiMember::query()
            ->select([
                'id',
                'name',
                'email',
                'phone',
                'image_path',
                'created_at',
                'updated_at',
            ])
            ->orderBy('name');

        $paginator = $query->paginate($validated['per_page'] ?? 15);

        $paginator->getCollection()->transform(function (KoperasiMember $m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'email' => $m->email,
                'phone' => $m->phone,
                'image_url' => $m->image_path ? asset('storage/' . $m->image_path) : null,
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
     * GET /api/v1/members/{member}
     * Public detail by id (uuid)
     */
    public function show(KoperasiMember $member)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'phone' => $member->phone,
                'image_url' => $member->image_path ? asset('storage/' . $member->image_path) : null,
                'created_at' => $member->created_at?->toISOString(),
                'updated_at' => $member->updated_at?->toISOString(),
            ],
        ]);
    }
}