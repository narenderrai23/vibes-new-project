<?php

namespace Modules\Student\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Student\Models\Student;
use Yajra\DataTables\DataTables;

class StudentsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Students';

        // module name
        $this->module_name = 'students';

        // directory path of the module
        $this->module_path = 'student::backend';

        // module icon
        $this->module_icon = 'ph-light ph-student';

        // module model name, path
        $this->module_model = Student::class;
    }

    /**
     * Server-side datatable feed.
     */
    public function index_data(): JsonResponse
    {
        $data = Student::select('students.*');

        return DataTables::of($data)
            ->addColumn('status_label', fn ($r) => $r->status_label)
            ->addColumn('action', function ($row) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name'))->with('data', $row);
            })
            ->editColumn('name', fn ($r) => '<strong>'.e($r->name).'</strong>')
            ->editColumn('enrollment_number', fn ($r) => $r->enrollment_number
                ? '<span class="badge bg-secondary">'.e($r->enrollment_number).'</span>'
                : '—')
            ->editColumn('updated_at', function ($row) {
                $diff = Carbon::now()->diffInHours($row->updated_at);

                return $diff < 25
                    ? $row->updated_at->diffForHumans()
                    : $row->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'enrollment_number', 'status_label', 'action'])
            ->make(true);
    }

    /**
     * Store a new student. Password is auto-generated; admin resets later.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->rules());

        extract($this->moduleContext());

        $module_action = 'Store';

        $data = $request->except(['_token', '_method', 'password']);
        $data['password'] = Str::password(12);

        $student = DB::transaction(fn () => Student::create($data));

        flash("New '".Str::singular($module_title)."' Added. A random password was generated — use password reset to set credentials.")->success()->important();

        logUserAccess("{$module_title} {$module_action} | Id: {$student->id}");

        return redirect("admin/{$module_name}");
    }

    /**
     * Update an existing student. Password is never changed here.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate($this->rules($id));

        extract($this->moduleContext());

        $module_action = 'Update';

        $data = $request->except(['_token', '_method', 'password']);

        $student = DB::transaction(function () use ($data, $id) {
            $record = Student::findOrFail($id);
            $record->update($data);

            return $record;
        });

        flash(Str::singular($module_title).' Updated Successfully')->success()->important();

        logUserAccess("{$module_title} {$module_action} | Id: {$student->id}");

        return redirect()->route("backend.{$module_name}.show", $student->id);
    }

    /**
     * Validation rules shared by store/update.
     *
     * @param  int|null  $id  Ignore this id for unique checks (on update).
     */
    private function rules($id = null): array
    {
        $emailUnique = 'unique:students,email'.($id ? ",{$id}" : '');
        $enrollUnique = 'unique:students,enrollment_number'.($id ? ",{$id}" : '');

        return [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', $emailUnique],
            'mobile'            => ['nullable', 'string', 'max:20'],
            'gender'            => ['nullable', 'in:male,female,other'],
            'date_of_birth'     => ['nullable', 'date'],
            'address'           => ['nullable', 'string', 'max:500'],
            'enrollment_number' => ['nullable', 'string', 'max:255', $enrollUnique],
            'course'            => ['nullable', 'string', 'max:255'],
            'batch'             => ['nullable', 'string', 'max:255'],
            'status'            => ['required', 'integer', 'in:0,1,2'],
        ];
    }
}
