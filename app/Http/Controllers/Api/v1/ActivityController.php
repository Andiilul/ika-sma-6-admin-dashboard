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
            'location' => ['nullable', 'string'], // or restrict with in:... if you have fixed enums
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
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
                $validated['location'] ?? null,
                fn($q, $location) =>
                $q->where('location', $location)
            )
            ->when(
                $validated['from'] ?? null,
                fn($q, $from) =>
                $q->whereDate('date', '>=', $from)
            )
            ->when(
                $validated['to'] ?? null,
                fn($q, $to) =>
                $q->whereDate('date', '<=', $to)
            )
            ->orderByDesc('date')
            ->orderBy('title');

        return response()->json([
            'status' => 'success',
            'data' => $query->paginate($validated['per_page'] ?? 15),
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

                // cast already returns Carbon if not null, safe chain for null
                'date' => $activity->date, // will serialize as Y-m-d because of the cast format

                'location' => $activity->location,

                'image_url' => $activity->image_path
                    ? asset('storage/' . $activity->image_path)
                    : null,
            ],
        ]);
    }
}
