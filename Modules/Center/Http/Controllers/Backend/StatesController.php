<?php

namespace Modules\Center\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\Center\Models\State;
use Yajra\DataTables\DataTables;

class StatesController extends Controller
{
    use Authorizable;

    public string $module_title = 'States';
    public string $module_name  = 'states';
    public string $module_path  = 'center::backend';
    public string $module_icon  = 'ph-light ph-map-pin';
    public string $module_model = State::class;

    protected function moduleContext(): array
    {
        return [
            'module_title'         => $this->module_title,
            'module_name'          => $this->module_name,
            'module_path'          => $this->module_path,
            'module_icon'          => $this->module_icon,
            'module_model'         => $this->module_model,
            'module_name_singular' => Str::singular($this->module_name),
        ];
    }

    public function index(): View
    {
        extract($this->moduleContext());
        $module_action = 'List';
        logUserAccess("{$module_title} {$module_action}");

        return view("{$module_path}.{$module_name}.index_datatable",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action'));
    }

    public function index_data(): JsonResponse
    {
        extract($this->moduleContext());

        $data = State::with('country')->select('states.*');

        return DataTables::of($data)
            ->addColumn('country', fn ($row) => $row->country?->name ?? '—')
            ->addColumn('action', function ($row) {
                $module_name = $this->module_name;
                return view('backend.includes.action_column', compact('module_name', 'row'))
                    ->with('data', $row);
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('updated_at', function ($row) {
                $diff = Carbon::now()->diffInHours($row->updated_at);
                return $diff < 25 ? $row->updated_at->diffForHumans() : $row->updated_at->isoFormat('llll');
            })
            ->rawColumns(['name', 'action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    public function index_list(Request $request): JsonResponse
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $results = State::where('name', 'LIKE', "%{$term}%")->limit(10)->get(['id', 'name'])
            ->map(fn ($s) => ['id' => $s->id, 'text' => $s->name]);

        return response()->json($results);
    }

    public function create(): View
    {
        extract($this->moduleContext());
        $module_action = 'Create';
        logUserAccess("{$module_title} {$module_action}");

        return view("{$module_path}.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action'));
    }

    public function store(Request $request): RedirectResponse
    {
        extract($this->moduleContext());

        $validated = $request->validate([
            'name'       => 'required|string|max:191',
            'state_code' => 'nullable|string|max:10',
            'country_id' => 'required|exists:countries,id',
        ]);

        $state = State::create($validated);

        flash("New State '{$state->name}' added.")->success()->important();
        logUserAccess("{$module_title} Store | Id: {$state->id}");

        return redirect("admin/{$module_name}");
    }

    public function show(int $id): View
    {
        extract($this->moduleContext());
        $module_action = 'Show';

        $state = State::with('country')->findOrFail($id);
        logUserAccess("{$module_title} {$module_action} | Id: {$id}");

        return view("{$module_path}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
            + ["{$module_name_singular}" => $state]);
    }

    public function edit(int $id): View
    {
        extract($this->moduleContext());
        $module_action = 'Edit';

        $state = State::findOrFail($id);
        logUserAccess("{$module_title} {$module_action} | Id: {$id}");

        return view("{$module_path}.{$module_name}.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular')
            + ["{$module_name_singular}" => $state]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        extract($this->moduleContext());

        $validated = $request->validate([
            'name'       => 'required|string|max:191',
            'state_code' => 'nullable|string|max:10',
            'country_id' => 'required|exists:countries,id',
        ]);

        $state = State::findOrFail($id);
        $state->update($validated);

        flash("State '{$state->name}' updated.")->success()->important();
        logUserAccess("{$module_title} Update | Id: {$id}");

        return redirect()->route("backend.{$module_name}.show", $id);
    }

    public function destroy(int $id): RedirectResponse
    {
        extract($this->moduleContext());

        $state = State::findOrFail($id);
        $name = $state->name;
        $state->delete();

        flash("State '{$name}' deleted.")->success()->important();
        logUserAccess("{$module_title} Destroy | Id: {$id}");

        return redirect("admin/{$module_name}");
    }

    public function trashed(): View
    {
        extract($this->moduleContext());
        $module_action = 'Trash List';

        $$module_name = State::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        logUserAccess("{$module_title} {$module_action}");

        return view("{$module_path}.{$module_name}.trash",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action')
            + ["{$module_name}" => $$module_name]);
    }

    public function restore(int $id): RedirectResponse
    {
        extract($this->moduleContext());

        $state = State::withTrashed()->findOrFail($id);
        $state->restore();

        flash("State '{$state->name}' restored.")->success()->important();
        logUserAccess("{$module_title} Restore | Id: {$id}");

        return redirect("admin/{$module_name}");
    }
}
