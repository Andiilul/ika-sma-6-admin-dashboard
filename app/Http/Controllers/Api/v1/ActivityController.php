<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * GET /api/v1/activity
     * Public list with filters & pagination
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search_title' => ['nullable', 'string', 'max:255'],
            'search_location' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Activity::query()
            ->select([
                'id',
                'title',
                'short_description',
                'description',
                'date',
                'location',
                'image_path',
            ])
            ->when(
                $validated['search_title'] ?? null,
                fn($q, $searchTitle) =>
                $q->where('title', 'like', '%' . $searchTitle . '%')
            )
            ->when(
                $validated['search_location'] ?? null,
                fn($q, $searchLocation) =>
                $q->where('location', 'like', '%' . $searchLocation . '%')
            )
            ->when(
                $validated['date_from'] ?? null,
                fn($q, $dateFrom) =>
                $q->whereDate('date', '>=', $dateFrom)
            )
            ->when(
                $validated['date_to'] ?? null,
                fn($q, $dateTo) =>
                $q->whereDate('date', '<=', $dateTo)
            )
            ->orderByDesc('date')
            ->orderBy('title');

        $paginator = $query->paginate($validated['per_page'] ?? 15)
            ->appends($request->query());

        $paginator->getCollection()->transform(function (Activity $activity) {
            return [
                'id' => $activity->id,
                'title' => $activity->title,
                'short_description' => $activity->short_description,
                'date' => $activity->date,
                'location' => $activity->location,
                'image_url' => $activity->image_path
                    ? asset('storage/' . $activity->image_path)
                    : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $paginator,
        ]);
    }

    /**
     * GET /api/v1/activity/{id}
     * Public detail
     */
    public function show(Activity $activity)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $activity->id,
                'title' => $activity->title,
                'short_description' => $activity->short_description,
                'description' => $activity->description,
                'date' => $activity->date,
                'location' => $activity->location,
                'image_url' => $activity->image_path
                    ? asset('storage/' . $activity->image_path)
                    : null,
            ],
        ]);
    }
}