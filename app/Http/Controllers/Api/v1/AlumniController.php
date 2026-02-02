<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * GET /api/v1/alumni
     * Public list with filters & pagination
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'graduation_year' => ['nullable', 'integer'],
            'location' => ['nullable', 'in:makassar,non-makassar'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Alumni::query()
            ->select([
                'id',
                'name',
                'nisn',
                'graduation_year',
                'location',
                'ethnicity',
                'domicile',
                'profession',
                'position',
                'hobby',
                'contact_number',
                'image_path',
            ])
            ->when($validated['graduation_year'] ?? null, fn ($q, $year) =>
                $q->where('graduation_year', $year)
            )
            ->when($validated['location'] ?? null, fn ($q, $location) =>
                $q->where('location', $location)
            )
            ->orderByDesc('graduation_year')
            ->orderBy('name');

        return response()->json([
            'status' => 'success',
            'data' => $query->paginate($validated['per_page'] ?? 15),
        ]);
    }

    /**
     * GET /api/v1/alumni/{id}
     * Public detail
     */
    public function show(Alumni $alumni)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $alumni->id,
                'name' => $alumni->name,
                'nisn' => $alumni->nisn,
                'graduation_year' => $alumni->graduation_year,
                'location' => $alumni->location,
                'ethnicity' => $alumni->ethnicity,
                'domicile' => $alumni->domicile,
                'address' => $alumni->address,
                'profession' => $alumni->profession,
                'position' => $alumni->position,
                'hobby' => $alumni->hobby,
                'contact_number' => $alumni->contact_number,
                'image_url' => $alumni->image_path
                    ? asset('storage/' . $alumni->image_path)
                    : null,
            ],
        ]);
    }
}
