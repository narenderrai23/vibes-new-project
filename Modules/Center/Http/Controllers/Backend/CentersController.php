<?php

namespace Modules\Center\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Center\Models\Center;
use Yajra\DataTables\DataTables;

class CentersController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        $this->module_title = 'Centers';
        $this->module_name  = 'centers';
        $this->module_path  = 'center::backend';
        $this->module_icon  = 'ph-light ph-buildings';
        $this->module_model = Center::class;
    }

    /** @override */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code'        => ['required', 'string', 'max:20', 'unique:centers,code'],
            'name'        => ['required', 'string', 'max:255'],
            'mobile'      => ['required', 'string', 'max:15'],
            'mobile_alt'  => ['nullable', 'string', 'max:15'],
            'email'       => ['nullable', 'email', 'max:255'],
            'address'     => ['nullable', 'string', 'max:500'],
            'google_link' => ['nullable', 'url', 'max:500'],
            'city'        => ['nullable', 'string', 'max:100'],
            'gst_no'      => ['nullable', 'string', 'max:15'],
            'state_id'    => ['required', 'integer', 'exists:states,id'],
            'regional_id' => ['nullable', 'integer', 'exists:regionals,id'],
            'status'      => ['required', 'integer', 'in:0,1,2'],
        ], [
            'code.required'     => 'Center code is required.',
            'code.unique'       => 'This center code is already taken.',
            'name.required'     => 'Center name is required.',
            'mobile.required'   => 'Mobile number is required.',
            'state_id.required' => 'State is required.',
            'status.required'   => 'Status is required.',
        ]);

        // Uppercase code and gst_no before saving
        $data = $request->all();
        $data['code']   = strtoupper(trim($data['code']));
        $data['gst_no'] = isset($data['gst_no']) ? strtoupper(trim($data['gst_no'])) : null;

        extract($this->moduleContext());

        $module_action = 'Store';

        $center = DB::transaction(fn () => Center::create($data));

        flash("New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess("{$module_title} {$module_action} | Id: {$center->id}");

        return redirect("admin/{$module_name}");
    }

    /** @override */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'code'        => ['required', 'string', 'max:20', "unique:centers,code,{$id}"],
            'name'        => ['required', 'string', 'max:255'],
            'mobile'      => ['required', 'string', 'max:15'],
            'mobile_alt'  => ['nullable', 'string', 'max:15'],
            'email'       => ['nullable', 'email', 'max:255'],
            'address'     => ['nullable', 'string', 'max:500'],
            'google_link' => ['nullable', 'url', 'max:500'],
            'city'        => ['nullable', 'string', 'max:100'],
            'gst_no'      => ['nullable', 'string', 'max:15'],
            'state_id'    => ['required', 'integer', 'exists:states,id'],
            'regional_id' => ['nullable', 'integer', 'exists:regionals,id'],
            'status'      => ['required', 'integer', 'in:0,1,2'],
        ], [
            'code.required'     => 'Center code is required.',
            'code.unique'       => 'This center code is already taken.',
            'name.required'     => 'Center name is required.',
            'mobile.required'   => 'Mobile number is required.',
            'state_id.required' => 'State is required.',
            'status.required'   => 'Status is required.',
        ]);

        // Uppercase code and gst_no before saving
        $data = $request->all();
        $data['code']   = strtoupper(trim($data['code']));
        $data['gst_no'] = isset($data['gst_no']) ? strtoupper(trim($data['gst_no'])) : null;

        extract($this->moduleContext());

        $module_action = 'Update';

        $center = DB::transaction(function () use ($data, $id) {
            $record = Center::findOrFail($id);
            $record->update($data);

            return $record;
        });

        flash(Str::singular($module_title)." Updated Successfully")->success()->important();

        logUserAccess("{$module_title} {$module_action} | Id: {$center->id}");

        return redirect()->route("backend.{$module_name}.show", $center->id);
    }

    public function edit($id): View
    {
        extract($this->moduleContext());

        $module_action = 'Edit';

        $$module_name_singular = $module_model::with('state.country')->findOrFail($id);

        logUserAccess("{$module_title} {$module_action} | Id: ".$$module_name_singular->id);

        return view(
            view: "{$module_path}.{$module_name}.edit",
            data: compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    public function index_data(): JsonResponse
    {
        $data = Center::with(['state', 'regional'])
            ->select('centers.*');

        return DataTables::of($data)
            ->addColumn('state',        fn ($r) => $r->state?->name    ?? '—')
            ->addColumn('regional',     fn ($r) => $r->regional?->name ?? '—')
            ->addColumn('status_label', fn ($r) => $r->status_label)
            ->addColumn('action', function ($row) {
                $module_name = $this->module_name;
                return view('backend.includes.action_column', compact('module_name'))
                    ->with('data', $row);
            })
            ->editColumn('name', fn ($r) => '<strong>' . e($r->name) . '</strong>')
            ->editColumn('code', fn ($r) => $r->code
                ? '<span class="badge bg-secondary">' . e($r->code) . '</span>'
                : '—')
            ->editColumn('updated_at', function ($row) {
                $diff = Carbon::now()->diffInHours($row->updated_at);
                return $diff < 25
                    ? $row->updated_at->diffForHumans()
                    : $row->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'code', 'status_label', 'action'])
            ->make(true);
    }
}
