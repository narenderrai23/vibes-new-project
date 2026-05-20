<?php

namespace Modules\Center\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Modules\Center\Models\Regional;
use Yajra\DataTables\DataTables;

class RegionalsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        $this->module_title = 'Regionals';
        $this->module_name  = 'regionals';
        $this->module_path  = 'center::backend';
        $this->module_icon  = 'ph-light ph-map-trifold';
        $this->module_model = Regional::class;
    }

    /**
     * Override index_data to include head center, centers count, and status_label.
     */
    public function index_data(): JsonResponse
    {
        $data = Regional::withCount('centers')
            ->with('headCenter')
            ->select('regionals.*');

        return DataTables::of($data)
            ->addColumn('head_center', fn ($row) => $row->headCenter?->name ?? '—')
            ->addColumn('centers_count', fn ($row) => $row->centers_count)
            ->addColumn('status_label', fn ($row) => $row->status_label)
            ->addColumn('action', function ($row) {
                $module_name = $this->module_name;
                return view('backend.includes.action_column', compact('module_name'))
                    ->with('data', $row);
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('updated_at', function ($row) {
                $diff = Carbon::now()->diffInHours($row->updated_at);
                return $diff < 25
                    ? $row->updated_at->diffForHumans()
                    : $row->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'status_label', 'action'])
            ->make(true);
    }
}
