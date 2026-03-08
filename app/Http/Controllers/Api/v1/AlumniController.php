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
            'search_name' => ['nullable', 'string', 'max:255'],
            'search_nisn' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'integer'],
            'location' => ['nullable', 'in:makassar,non-makassar'],
            'gender' => ['nullable', 'in:male,female'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Alumni::query()
            ->select([
                'id',
                'name',
                'nisn',
                'gender',
                'graduation_year',
                'location',
                'ethnicity',
                'domicile',
                'profession',
                'position',
                'hobby',
                'contact_number',
                'email',
                'image_path',
            ])
            ->when(
                $validated['search_name'] ?? null,
                fn ($q, $searchName) =>
                $q->where('name', 'like', '%' . $searchName . '%')
            )
            ->when(
                $validated['search_nisn'] ?? null,
                fn ($q, $searchNisn) =>
                $q->where('nisn', 'like', '%' . $searchNisn . '%')
            )
            ->when(
                $validated['graduation_year'] ?? null,
                fn ($q, $year) =>
                $q->where('graduation_year', $year)
            )
            ->when(
                $validated['location'] ?? null,
                fn ($q, $location) =>
                $q->where('location', $location)
            )
            ->when(
                $validated['gender'] ?? null,
                fn ($q, $gender) =>
                $q->where('gender', $gender)
            )
            ->orderByDesc('graduation_year')
            ->orderBy('name');

        $paginator = $query->paginate($validated['per_page'] ?? 15)
            ->appends($request->query());

        $paginator->getCollection()->transform(function (Alumni $alumni) {
            return [
                'id' => $alumni->id,
                'name' => $alumni->name,
                'nisn' => $alumni->nisn,
                'gender' => $alumni->gender,
                'graduation_year' => $alumni->graduation_year,
                'location' => $alumni->location,
                'ethnicity' => $alumni->ethnicity,
                'domicile' => $alumni->domicile,
                'profession' => $alumni->profession,
                'position' => $alumni->position,
                'hobby' => $alumni->hobby,
                'contact_number' => $alumni->contact_number,
                'email' => $alumni->email,
                'image_url' => $alumni->image_path
                    ? asset('storage/' . $alumni->image_path)
                    : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $paginator,
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
                'gender' => $alumni->gender,
                'graduation_year' => $alumni->graduation_year,
                'location' => $alumni->location,
                'ethnicity' => $alumni->ethnicity,
                'domicile' => $alumni->domicile,
                'address' => $alumni->address,
                'profession' => $alumni->profession,
                'position' => $alumni->position,
                'hobby' => $alumni->hobby,
                'contact_number' => $alumni->contact_number,
                'email' => $alumni->email,
                'image_url' => $alumni->image_path
                    ? asset('storage/' . $alumni->image_path)
                    : null,
            ],
        ]);
    }
}