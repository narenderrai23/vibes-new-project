<?php

namespace Modules\Center\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Center\Models\Center;
use Modules\Center\Models\State;

class AjaxController extends Controller
{
    /**
     * Return states for a given country — used by dependent dropdown.
     * GET /admin/ajax/states-by-country/{country_id}
     */
    public function statesByCountry(int $country_id): JsonResponse
    {
        $states = State::where('country_id', $country_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($states);
    }

    /**
     * Return centers for a given regional — used by dependent dropdown.
     * GET /admin/ajax/centers-by-regional/{regional_id}
     */
    public function centersByRegional(int $regional_id): JsonResponse
    {
        $centers = Center::where('regional_id', $regional_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($centers);
    }
}
