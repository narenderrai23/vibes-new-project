<?php

namespace Modules\Trainer\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Trainer\Models\Trainer;
use Yajra\DataTables\DataTables;

class TrainersController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Trainers';

        // module name
        $this->module_name = 'trainers';

        // directory path of the module
        $this->module_path = 'trainer::backend';

        // module icon
        $this->module_icon = 'ph-light ph-chalkboard-teacher';

        // module model name, path
        $this->module_model = Trainer::class;
    }

    /**
     * Server-side datatable feed.
     */
    public function index_data(): JsonResponse
    {
        $data = Trainer::select('trainers.*');

        return DataTables::of($data)
            ->addColumn('status_label', fn ($r) => $r->status_label)
            ->addColumn('action', function ($row) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name'))->with('data', $row);
            })
            ->editColumn('name', fn ($r) => '<strong>'.e($r->name).'</strong>')
            ->editColumn('specialization', fn ($r) => $r->specialization ? e($r->specialization) : '—')
            ->editColumn('updated_at', function ($row) {
                $diff = Carbon::now()->diffInHours($row->updated_at);

                return $diff < 25
                    ? $row->updated_at->diffForHumans()
                    : $row->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'status_label', 'action'])
            ->make(true);
    }

    /**
     * Store a new trainer. Password is auto-generated; admin resets later.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->rules());

        extract($this->moduleContext());

        $module_action = 'Store';

        $data = $request->except(['_token', '_method', 'password']);
        $data['password'] = Str::password(12);

        $trainer = DB::transaction(fn () => Trainer::create($data));

        flash("New '".Str::singular($module_title)."' Added. A random password was generated — use password reset to set credentials.")->success()->important();

        logUserAccess("{$module_title} {$module_action} | Id: {$trainer->id}");

        return redirect("admin/{$module_name}");
    }

    /**
     * Update an existing trainer. Password is never changed here.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate($this->rules($id));

        extract($this->moduleContext());

        $module_action = 'Update';

        $data = $request->except(['_token', '_method', 'password']);

        $trainer = DB::transaction(function () use ($data, $id) {
            $record = Trainer::findOrFail($id);
            $record->update($data);

            return $record;
        });

        flash(Str::singular($module_title).' Updated Successfully')->success()->important();

        logUserAccess("{$module_title} {$module_action} | Id: {$trainer->id}");

        return redirect()->route("backend.{$module_name}.show", $trainer->id);
    }

    /**
     * Validation rules shared by store/update.
     *
     * @param  int|null  $id  Ignore this id for unique checks (on update).
     */
    private function rules($id = null): array
    {
        $emailUnique = 'unique:trainers,email'.($id ? ",{$id}" : '');

        return [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', $emailUnique],
            'mobile'           => ['nullable', 'string', 'max:20'],
            'gender'           => ['nullable', 'in:male,female,other'],
            'date_of_birth'    => ['nullable', 'date'],
            'address'          => ['nullable', 'string', 'max:500'],
            'specialization'   => ['nullable', 'string', 'max:255'],
            'qualification'    => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:80'],
            'bio'              => ['nullable', 'string', 'max:2000'],
            'status'           => ['required', 'integer', 'in:0,1,2'],
        ];
    }
}
